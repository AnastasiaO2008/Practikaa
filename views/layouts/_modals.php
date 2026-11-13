  <div class="modal-backdrop" id="authModal" aria-hidden="true"><section class="modal" role="dialog" aria-modal="true" aria-labelledby="authTitle"><button class="modal-close" data-close-modal aria-label="Закрыть"><i data-lucide="x"></i></button><div class="modal-brand"><img src="<?= $assetBase ?>/logo-language-bloom.png" alt=""> <span>Language Bloom</span></div><h2 id="authTitle">Добро пожаловать!</h2><p class="modal-subtitle">Войди в свой дневник или создай аккаунт.</p><div class="auth-tabs"><button class="active" data-auth-tab="login">Войти</button><button data-auth-tab="register">Регистрация</button></div><form id="authForm"><label>Твоё имя<input id="authName" name="name" autocomplete="name" placeholder="Например, Настя"></label><label>Электронная почта<input id="authEmail" name="email" type="email" autocomplete="email" placeholder="name@example.com" required></label><label>Пароль<input id="authPassword" name="password" type="password" autocomplete="current-password" minlength="6" placeholder="Не менее 6 символов" required></label><button class="primary-button modal-submit" type="submit">Продолжить</button><p class="form-message" id="authMessage" role="status"></p></form></section></div>

  <div class="notification-popover" id="notificationPopover" role="status" aria-live="polite" aria-hidden="true">
    <div class="notification-popover-head"><strong>Уведомления</strong><button class="notification-close" id="closeNotifications" aria-label="Закрыть"><i data-lucide="x"></i></button></div>
    <div class="notification-list" id="notificationList">
      <article class="notification-item unread" data-notification="1"><span class="notification-symbol"><i data-lucide="flame"></i></span><div><strong>7 дней подряд!</strong><p>Ты занимаешься уже целую неделю. Так держать!</p><small>Сегодня · 09:00</small></div></article>
      <article class="notification-item unread" data-notification="2"><span class="notification-symbol"><i data-lucide="book-open"></i></span><div><strong>Пора повторить слова</strong><p>12 слов ждут тебя в словаре. Это займёт около 5 минут.</p><small>Сегодня · 08:30</small></div></article>
      <article class="notification-item unread" data-notification="3"><span class="notification-symbol"><i data-lucide="award"></i></span><div><strong>Новое достижение рядом</strong><p>Ещё 7 дней — и ты получишь значок за две недели в ритме.</p><small>Вчера</small></div></article>
    </div>
    <button class="mark-read-button" id="markNotificationsRead">Отметить все как прочитанные</button>
  </div>

  <div class="modal-backdrop" id="wordModal" aria-hidden="true"><section class="modal" role="dialog" aria-modal="true" aria-labelledby="wordModalTitle"><button class="modal-close" data-close-modal aria-label="Закрыть"><i data-lucide="x"></i></button><h2 id="wordModalTitle">Добавить слово</h2><form id="newWordForm"><label>Язык<select id="newWordLanguage"><option>Итальянский</option><option>Японский</option></select></label><label>Слово<input id="newWordText" required placeholder="Например, Ciao"></label><label>Транскрипция<input id="newWordTranscription" placeholder="[чао]"></label><label>Перевод<input id="newWordTranslation" required placeholder="Привет"></label><button class="primary-button modal-submit" type="submit">Сохранить слово</button></form></section></div>
  <div class="modal-backdrop" id="reviewModal" aria-hidden="true">
    <section class="modal review-modal" role="dialog" aria-modal="true" aria-labelledby="reviewTitle">
      <button class="modal-close" data-close-modal aria-label="Закрыть"><i data-lucide="x"></i></button>
      <p class="eyebrow">НЕБОЛЬШАЯ ПРАКТИКА</p><h2 id="reviewTitle">Время вспомнить слова</h2>
      <p class="modal-subtitle" id="reviewProgress">Карточка 1 из 1</p>
      <article class="study-flashcard" id="studyFlashcard"><span class="study-language" id="studyLanguage">Итальянский</span><strong id="studyWord">Dolce vita</strong><span id="studyTranscription">[ˈdoltʃe ˈviːta]</span><p id="studyTranslation" hidden>сладкая жизнь</p></article>
      <button class="outline-button reveal-answer" id="revealAnswer">Показать перевод</button>
      <div class="review-actions"><button class="outline-button" id="reviewAgain">Повторить ещё</button><button class="primary-button" id="reviewKnown">Знаю это слово</button></div>
      <p class="form-message" id="reviewFeedback" role="status"></p>
    </section>
  </div>

  <div class="modal-backdrop" id="rewardModal" aria-hidden="true">
    <section class="modal reward-modal" role="dialog" aria-modal="true" aria-labelledby="rewardTitle">
      <button class="modal-close" data-close-modal aria-label="Закрыть"><i data-lucide="x"></i></button>
      <p class="eyebrow">ЕЩЁ ОДИН ШАГ ВПЕРЁД</p>
      <h2 id="rewardTitle">Ты разблокировала новую карточку!</h2>
      <p class="modal-subtitle">Все слова повторены. В твоей коллекции появилось новое вдохновение.</p>
      <div class="reward-postcard-frame">
        <img class="reward-postcard-image" id="rewardPostcardImage" src="<?= $assetBase ?>/italy-card-amalfi.png" alt="Открытка с иллюстрацией изучаемой страны">
      </div>
      <blockquote class="reward-quote"><strong id="rewardQuoteTitle">La vita è bella</strong><span id="rewardQuoteText">«Жизнь прекрасна».</span><small id="rewardQuoteNote">Каждое повторение приближает тебя к цели.</small></blockquote>
      <button class="primary-button modal-submit" id="closeReward">Забрать карточку</button>
    </section>
  </div>

  <div class="toast" id="toast" role="status" aria-live="polite"></div>
