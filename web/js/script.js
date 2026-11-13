/* =========================================================
   LANGUAGE BLOOM — интерактивность дневника изучения языков
   ========================================================= */

const $ = (selector, root = document) => root.querySelector(selector);
const $$ = (selector, root = document) => [...root.querySelectorAll(selector)];

const initialWords = [
  {
    language: 'Итальянский',
    flag: '🇮🇹',
    word: 'Dolce vita',
    transcription: '[ˈdoltʃe ˈviːta]',
    translation: 'сладкая жизнь',
    example: 'La dolce vita italiana.',
    kind: 'Существительное',
    status: 'review'
  },
  {
    language: 'Японский',
    flag: '🇯🇵',
    word: 'せんせい',
    transcription: '[senseː]',
    translation: 'учитель',
    example: '田中さんはせんせいです。',
    kind: 'Существительное',
    status: 'review'
  },
  {
    language: 'Итальянский',
    flag: '🇮🇹',
    word: 'Viaggio',
    transcription: '[vjadːʒo]',
    translation: 'путешествие',
    example: 'Un viaggio in Italia.',
    kind: 'Существительное',
    status: 'learning'
  },
  {
    language: 'Японский',
    flag: '🇯🇵',
    word: 'ともだち',
    transcription: '[tomodatɕi]',
    translation: 'друг',
    example: 'ともだちと話します。',
    kind: 'Существительное',
    status: 'learning'
  },
  {
    language: 'Итальянский',
    flag: '🇮🇹',
    word: 'Buongiorno',
    transcription: '[bwɔnˈdʒorno]',
    translation: 'добрый день',
    example: 'Buongiorno, come stai?',
    kind: 'Выражение',
    status: 'learned'
  },
  {
    language: 'Японский',
    flag: '🇯🇵',
    word: 'ありがとう',
    transcription: '[arigatoː]',
    translation: 'спасибо',
    example: 'ありがとうございます。',
    kind: 'Выражение',
    status: 'learned'
  }
];

let words = [...initialWords];
let activeLanguage = 'all';
let activeStatus = 'all';
let authMode = 'login';
let reviewQueue = [];
let reviewIndex = 0;
let toastTimer;
let savedReward = null;
try {
  savedReward = JSON.parse(localStorage.getItem('languageBloomReward') || 'null');
} catch (error) {
  savedReward = null;
}
let rewardUnlocked = Boolean(savedReward) || localStorage.getItem('languageBloomRewardUnlocked') === 'true';

/* Иконки и небольшие интерфейсные сообщения */
function refreshIcons() {
  if (window.lucide) {
    window.lucide.createIcons();
  }
}

function showToast(message) {
  const toast = $('#toast');
  if (!toast) return;
  toast.textContent = message;
  toast.classList.add('show');
  window.clearTimeout(toastTimer);
  toastTimer = window.setTimeout(() => toast.classList.remove('show'), 2600);
}

function openModal(id) {
  const modal = document.getElementById(id);
  if (!modal) return;
  modal.classList.add('open');
  modal.setAttribute('aria-hidden', 'false');
  const firstInput = $('input', modal);

  if (firstInput) {
    window.setTimeout(() => firstInput.focus(), 80);
  }
}

function closeModal(modal) {
  modal.classList.remove('open');
  modal.setAttribute('aria-hidden', 'true');
}

/* Защита пользовательского текста при создании карточек */
function escapeHTML(value) {
  return String(value).replace(/[&<>"']/g, (character) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#39;'
  })[character]);
}

function createWordCard(word, compact = false) {
  const card = document.createElement('article');
  const colorClass = word.language === 'Итальянский' ? 'green-card' : 'pink-card';
  card.className = `word-card ${colorClass}`;

  if (compact) {
    card.innerHTML = `
      <div class="word-top">
        <img class="flag flag-round" src="${word.language === 'Итальянский' ? `${window.languageBloomAssetPath}/flag-italy.png` : `${window.languageBloomAssetPath}/flag-japan.png`}" alt="Флаг: ${escapeHTML(word.language)}">
        <h3>${escapeHTML(word.word)}</h3>
        <button class="sound-button" type="button" aria-label="Прослушать слово">
          <i data-lucide="volume-2"></i>
        </button>
      </div>
      <p class="transcription">${escapeHTML(word.transcription || '')}</p>
      <p class="translation">${escapeHTML(word.translation)}</p>
      <p class="word-kind">${escapeHTML(word.kind || 'Новое слово')}</p>
      <button class="star-button" type="button" aria-label="Добавить в избранное">★</button>
    `;
  } else {
    const statusLabels = {
      review: 'На повторение',
      learning: 'Изучаю',
      learned: '✓ Выучено'
    };

    card.innerHTML = `
      <div class="language-name">${escapeHTML(word.language)}</div>
      <button class="sound-button" type="button" aria-label="Прослушать слово">
        <i data-lucide="volume-2"></i>
      </button>
      <h3 class="word-main ${word.language === 'Японский' ? 'japanese' : ''}">
        ${escapeHTML(word.word)}
      </h3>
      <p class="transcription">${escapeHTML(word.transcription || '')}</p>
      <strong class="translation">${escapeHTML(word.translation)}</strong>
      <p class="example">${escapeHTML(word.example || '')}</p>
      <span class="word-status">${statusLabels[word.status] || 'Новое слово'}</span>
      <small class="word-type">${escapeHTML(word.kind || 'Слово')}</small>
    `;
  }

  return card;
}

/* Словарь: фильтр, поиск и сортировка */
function renderWords() {
  const grid = $('#wordsGrid');
  if (!grid || !$('#wordSearch') || !$('#wordSort') || !$('#shownCount')) return;
  const searchQuery = $('#wordSearch').value.trim().toLowerCase();
  let filteredWords = words.filter((word) => {
    const matchesLanguage = activeLanguage === 'all' || word.language === activeLanguage;
    const matchesStatus = activeStatus === 'all' || word.status === activeStatus;
    const searchableText = [word.word, word.translation, word.language, word.example]
      .join(' ')
      .toLowerCase();

    return matchesLanguage && matchesStatus && searchableText.includes(searchQuery);
  });

  if ($('#wordSort').value === 'az') {
    filteredWords = filteredWords.sort((first, second) => first.word.localeCompare(second.word));
  }

  grid.replaceChildren();
  filteredWords.forEach((word) => grid.append(createWordCard(word)));
  $('#shownCount').textContent = `Показано ${filteredWords.length} из ${words.length}`;

  if (!filteredWords.length) {
    const emptyMessage = document.createElement('p');
    emptyMessage.className = 'muted empty-words';
    emptyMessage.textContent = 'Пока ничего не найдено. Попробуй изменить запрос.';
    grid.append(emptyMessage);
  }

  refreshIcons();
}

function renderRepeatWords() {
  const repeatGrid = $('#repeatWords');
  if (!repeatGrid) return;
  repeatGrid.replaceChildren();
  words.filter((word) => word.status === 'review').slice(0, 2)
    .forEach((word) => repeatGrid.append(createWordCard(word, true)));
  refreshIcons();
}

/* Уведомления */
const notificationReadKey = 'languageBloomNotificationsRead';
function updateNotificationDot() {
  const read = localStorage.getItem(notificationReadKey) === 'true';
  const dot = $('.notification-dot');
  if (dot) {
    dot.classList.toggle('has-unread', !read);
    dot.classList.toggle('all-read', read);
  }
}
function markNotificationsRead() {
  localStorage.setItem(notificationReadKey, 'true');
  $$('.notification-item').forEach((item) => item.classList.remove('unread'));
  updateNotificationDot();
}
function toggleNotifications(forceClose = false) {
  const popover = $('#notificationPopover');
  if (!popover) return;
  const shouldOpen = !forceClose && popover.getAttribute('aria-hidden') === 'true';
  popover.classList.toggle('visible', shouldOpen);
  popover.setAttribute('aria-hidden', String(!shouldOpen));
}

/* Новая открытка за завершённое повторение.
   Итальянский: иллюстрации № 4 и № 6.
   Японский: иллюстрации № 5 и № 7. */
const rewardCollections = {
  'Итальянский': [
    {
      image: `${window.languageBloomAssetPath}/italy-card-amalfi.png`,
      title: 'La vita è bella',
      quote: '«Жизнь прекрасна».',
      note: 'Goditi ogni piccolo momento — наслаждайся каждым мгновением.'
    },
    {
      image: `${window.languageBloomAssetPath}/italy-card-vespa.png`,
      title: ' dolce far niente',
      quote: '«Сладость ничего не делать».',
      note: 'Иногда лучший прогресс — это позволить себе отдохнуть.'
    }
  ],
  'Японский': [
    {
      image: `${window.languageBloomAssetPath}/japan-card-clouds.png`,
      title: '七転び八起き',
      quote: '«Упади семь раз, поднимись восемь».',
      note: 'Не бойся ошибок: они тоже часть твоего пути.'
    },
    {
      image: `${window.languageBloomAssetPath}/japan-card-sakura.png`,
      title: '一歩ずつ',
      quote: '«Шаг за шагом».',
      note: 'Маленькие шаги каждый день приводят к большим открытиям.'
    }
  ]
};

function getRewardForLanguage(language) {
  const collection = rewardCollections[language] || rewardCollections['Итальянский'];
  const storageKey = `languageBloomRewardIndex_${language}`;
  const nextIndex = Number(localStorage.getItem(storageKey) || 0) % collection.length;
  localStorage.setItem(storageKey, String(nextIndex + 1));
  return { language, ...collection[nextIndex] };
}

function renderUnlockedReward() {
  if (!rewardUnlocked || !savedReward) return;

  const homeGrid = $('.home-grid');
  const earnedGrid = $('.earned-grid');
  if (!homeGrid && !earnedGrid) return;

  const cardTitle = escapeHTML(savedReward.title);
  const cardQuote = escapeHTML(savedReward.quote);
  const cardImage = escapeHTML(savedReward.image);
  const language = escapeHTML(savedReward.language);

  // Обновляем существующие карточки на обоих экранах, а не добавляем копии.
  // Поэтому последняя разблокированная открытка всегда синхронна на главной и в достижениях.
  let homeCard = homeGrid ? ($('#homeRewardCard') || $('.postcard-card', homeGrid)) : null;
  if (homeCard) {
    homeCard.id = 'homeRewardCard';
    homeCard.innerHTML = `
      <p class="muted">Ты разблокировала новую карточку!</p>
      <div class="postcard-content">
        <div><h3>${cardTitle}</h3><p>${cardQuote}</p><small>${language}</small></div>
        <img class="postcard-image reward-card-image" src="${cardImage}" alt="Новая открытка: ${language}">
      </div>`;
  }

  let earnedCard = earnedGrid ? ($('#earnedRewardCard') || $('.postcard-earned', earnedGrid)) : null;
  if (earnedCard) {
    earnedCard.id = 'earnedRewardCard';
    earnedCard.innerHTML = `
      <div><small>КАРТОЧКА · ${language.toUpperCase()}</small><h3>${cardTitle}</h3>
      <p>${cardQuote}</p><span>✓ Разблокировано</span></div>
      <img class="postcard-image" src="${cardImage}" alt="Открытка: ${language}">`;
  }
}

function unlockReward(language) {
  const reward = getRewardForLanguage(language);
  savedReward = reward;
  rewardUnlocked = true;
  localStorage.setItem('languageBloomReward', JSON.stringify(reward));
  localStorage.removeItem('languageBloomRewardUnlocked');

  renderUnlockedReward();
  $('#rewardPostcardImage').src = reward.image;
  $('#rewardPostcardImage').alt = `Открытка по языку: ${reward.language}`;
  $('#rewardQuoteTitle').textContent = reward.title.trim();
  $('#rewardQuoteText').textContent = reward.quote;
  $('#rewardQuoteNote').textContent = reward.note;
  openModal('rewardModal');
}

/* Повторение слов после учебного занятия */
function startReview() {
  reviewQueue = words.filter((word) => word.status === 'review' || word.status === 'learning');
  reviewIndex = 0;

  if (!reviewQueue.length) {
    showToast('На сегодня все слова повторены. Отличная работа!');
    return;
  }

  showReviewCard();
  openModal('reviewModal');
}

function showReviewCard() {
  const currentWord = reviewQueue[reviewIndex];
  $('#reviewProgress').textContent = `Карточка ${reviewIndex + 1} из ${reviewQueue.length}`;
  $('#studyLanguage').textContent = currentWord.language;
  $('#studyWord').textContent = currentWord.word;
  $('#studyTranscription').textContent = currentWord.transcription || '';
  $('#studyTranslation').textContent = currentWord.translation;
  $('#studyTranslation').hidden = true;
  $('#revealAnswer').hidden = false;
  $('#reviewFeedback').textContent = '';
}

function advanceReview(markAsKnown) {
  const currentWord = reviewQueue[reviewIndex];

  if (markAsKnown) {
    const originalWord = words.find((word) => word.word === currentWord.word);
    if (originalWord) originalWord.status = 'learned';
  }

  reviewIndex += 1;

  if (reviewIndex >= reviewQueue.length) {
    closeModal($('#reviewModal'));
    renderWords();
    renderRepeatWords();
    const languageCounts = reviewQueue.reduce((counts, word) => {
      counts[word.language] = (counts[word.language] || 0) + 1;
      return counts;
    }, {});
    const rewardLanguage = Object.entries(languageCounts)
      .sort((first, second) => second[1] - first[1] || (first[0] === currentWord.language ? -1 : 1))[0]?.[0] || currentWord.language;
    unlockReward(rewardLanguage);
    return;
  }

  showReviewCard();
}

/* Регистрация и вход */
function setAuthMode(mode) {
  authMode = mode;
  $$('[data-auth-tab]').forEach((button) => {
    button.classList.toggle('active', button.dataset.authTab === mode);
  });

  $('#authName').parentElement.hidden = mode === 'login';
  $('#authPassword').autocomplete = mode === 'login' ? 'current-password' : 'new-password';
  $('#authTitle').textContent = mode === 'login' ? 'С возвращением!' : 'Создай свой аккаунт';
  $('.modal-subtitle').textContent = mode === 'login'
    ? 'Войди в свой дневник и продолжай учиться.'
    : 'Заполни данные, чтобы начать свой языковой путь.';
  $('.modal-submit').textContent = mode === 'login' ? 'Войти' : 'Зарегистрироваться';
  $('#authMessage').textContent = '';
}

// Данные профиля берутся из серверной сессии Yii2 и HTML, а не из
// localStorage (где могла остаться устаревшая информация о другом аккаунте).
function loadUser() {
  localStorage.removeItem('languageBloomUser');
}

async function saveNewWord(event) {
  event.preventDefault();
  const payload = {
    language: $('#newWordLanguage').value,
    word: $('#newWordText').value.trim(),
    transcription: $('#newWordTranscription').value.trim(),
    translation: $('#newWordTranslation').value.trim()
  };
  const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
  try {
    const response = await fetch(window.languageBloomRoutes.createWordApi || '/api/create-word', {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        'X-CSRF-Token': csrf
      },
      body: new URLSearchParams(payload)
    });
    const result = await response.json();
    if (!response.ok || !result.success) {
      showToast(result.message || 'Не удалось сохранить слово. Войди в аккаунт и попробуй снова.');
      return;
    }
    event.target.reset();
    closeModal($('#wordModal'));
    const listResponse = await fetch(window.languageBloomRoutes.wordsApi, {credentials: 'same-origin'});
    const list = await listResponse.json();
    if (list.success) {
      words = list.words;
      renderWords();
      renderRepeatWords();
    }
    showToast('Слово сохранено в базе данных!');
  } catch (error) {
    showToast('Не удалось связаться с сервером. Проверь подключение.');
  }
}

function handleAuthSubmit(event) {
  event.preventDefault();
  // Аутентификация выполняется сервером Yii2. Эта модальная форма больше
  // не сохраняет пароль в localStorage: открываем защищённую форму входа/регистрации.
  const target = authMode === 'register'
    ? (window.languageBloomRoutes.register || '/site/register')
    : '/site/login';
  window.location.href = target;
}

/* Небольшое упражнение на экране японской грамматики */
function checkGrammarAnswer(answer) {
  const feedback = $('#grammarFeedback');
  if (!feedback) return;
  const choices = $$('[data-grammar-choice]');

  choices.forEach((button) => button.classList.toggle('active', button.dataset.grammarChoice === answer));

  if (answer === 'は') {
    feedback.textContent = 'Верно! は обозначает тему: «Что касается меня, я Настя». Так держать!';
    feedback.classList.add('correct');
  } else {
    feedback.textContent = 'Попробуй ещё раз: здесь мы обозначаем тему предложения — говорим о себе.';
    feedback.classList.remove('correct');
  }
}

/* Обработчики интерфейса */
$$('[data-go]').forEach((button) => {
  button.addEventListener('click', () => {
    const routes = { words: window.languageBloomRoutes.words, achievements: window.languageBloomRoutes.achievements, home: window.languageBloomRoutes.home, grammar: window.languageBloomRoutes.grammar };
    if (routes[button.dataset.go]) window.location.href = routes[button.dataset.go];
  });
});



$$('[data-language]').forEach((button) => {
  button.addEventListener('click', () => {
    activeLanguage = button.dataset.language;
    $$('[data-language]').forEach((item) => item.classList.toggle('active', item === button));
    renderWords();
  });
});

$$('[data-status]').forEach((button) => {
  button.addEventListener('click', () => {
    activeStatus = button.dataset.status;
    $$('[data-status]').forEach((item) => item.classList.toggle('active', item === button));
    renderWords();
  });
});

$('#wordSearch')?.addEventListener('input', renderWords);
$('#wordSort')?.addEventListener('change', renderWords);
$('#addWordButton')?.addEventListener('click', () => openModal('wordModal'));
$('#newWordForm')?.addEventListener('submit', saveNewWord);
$('#startReview')?.addEventListener('click', startReview);
$('#continueSession')?.addEventListener('click', () => { window.location.href = window.languageBloomRoutes.grammar; });
$('#backFromGrammar')?.addEventListener('click', () => { window.location.href = window.languageBloomRoutes.home; });
$('#finishGrammar')?.addEventListener('click', async () => {
  const button = $('#finishGrammar');
  const originalText = button.textContent;
  button.disabled = true;
  button.textContent = 'Сохраняем занятие…';
  try {
    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const response = await fetch(window.languageBloomRoutes.completeLesson, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        'X-CSRF-Token': token,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: new URLSearchParams({_csrf: token}).toString()
    });
    const result = await response.json();
    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Не удалось сохранить занятие.');
    }
    window.location.href = window.languageBloomRoutes.home;
  } catch (error) {
    alert(error.message || 'Не удалось сохранить занятие. Попробуй ещё раз.');
    button.disabled = false;
    button.textContent = originalText;
  }
});

$('#notificationButton')?.addEventListener('click', () => toggleNotifications());
$('#closeNotifications')?.addEventListener('click', () => toggleNotifications(true));
$('#markNotificationsRead')?.addEventListener('click', markNotificationsRead);
$('#notificationList')?.addEventListener('click', (event) => {
  const item = event.target.closest('.notification-item');
  if (item) {
    item.classList.remove('unread');
    if (!$('.notification-item.unread')) markNotificationsRead();
  }
});
document.addEventListener('click', (event) => {
  if (!event.target.closest('.notification-popover') && !event.target.closest('#notificationButton')) {
    toggleNotifications(true);
  }
});

$('#revealAnswer')?.addEventListener('click', () => {
  $('#studyTranslation').hidden = false;
  $('#revealAnswer').hidden = true;
});
$('#reviewAgain')?.addEventListener('click', () => advanceReview(false));
$('#reviewKnown')?.addEventListener('click', () => advanceReview(true));
$('#closeReward')?.addEventListener('click', () => closeModal($('#rewardModal')));
$('#prevPage')?.addEventListener('click', () => showToast('Это единственная страница твоего словаря.'));
$('#nextPage')?.addEventListener('click', () => showToast('Ты уже на последней странице.'));

// Аватар — обычная ссылка, сформированная Yii2 с учётом сессии.
// Не перехватываем клик модальным окном: у авторизованного это /site/profile,
// у гостя — /site/login.
$('#editProfile')?.addEventListener('click', () => {
  window.location.href = window.languageBloomRoutes.profile;
});

$$('[data-auth-tab]').forEach((button) => {
  button.addEventListener('click', () => setAuthMode(button.dataset.authTab));
});
$('#authForm')?.addEventListener('submit', handleAuthSubmit);

$$('[data-close-modal]').forEach((button) => {
  button.addEventListener('click', () => closeModal(button.closest('.modal-backdrop')));
});

$$('.modal-backdrop').forEach((backdrop) => {
  backdrop.addEventListener('click', (event) => {
    if (event.target === backdrop) closeModal(backdrop);
  });
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') {
    $$('.modal-backdrop.open').forEach(closeModal);
    toggleNotifications(true);
  }
});

$$('[data-grammar-choice]').forEach((button) => {
  button.addEventListener('click', () => checkGrammarAnswer(button.dataset.grammarChoice));
});

/* Дата и начальная отрисовка */
const currentDate = new Date();
if ($('#todayDate')) $('#todayDate').textContent = new Intl.DateTimeFormat('ru-RU', {
  day: 'numeric',
  month: 'long',
  year: 'numeric'
}).format(currentDate);

if (localStorage.getItem(notificationReadKey) === 'true') {
  $$('.notification-item').forEach((item) => item.classList.remove('unread'));
}
updateNotificationDot();
if ($('#wordsGrid')) {
  fetch(window.languageBloomRoutes.wordsApi, {credentials: 'same-origin'})
    .then((response) => response.json())
    .then((result) => {
      if (result.success && result.words.length) {
        words = result.words;
        renderWords();
        renderRepeatWords();
      } else {
        renderWords();
      }
    })
    .catch(() => renderWords());
}
if ($('#repeatWords')) renderRepeatWords();
renderUnlockedReward();
if (savedReward && $('#rewardPostcardImage')) {
  $('#rewardPostcardImage').src = savedReward.image;
  $('#rewardPostcardImage').alt = `Открытка по языку: ${savedReward.language}`;
  $('#rewardQuoteTitle').textContent = savedReward.title.trim();
  $('#rewardQuoteText').textContent = savedReward.quote;
  $('#rewardQuoteNote').textContent = savedReward.note;
}
loadUser();
refreshIcons();
