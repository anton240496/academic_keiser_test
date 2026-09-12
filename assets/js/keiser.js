// ─────────────────────────────────────────────────────────────────────
// keiser.js — логика сайта: переключение языков EN/RU и трекинг кликов.
// Тексты переводов приходят из header.php (объект keiserTranslations),
// который в свою очередь берёт их из Carbon Fields (база данных).
// ─────────────────────────────────────────────────────────────────────

// Переводы — берём из объекта, вставленного PHP в header.php
const translations = {
  en: keiserTranslations.en,
  ru: keiserTranslations.ru
};

// Текущий язык сайта (по умолчанию английский)
let currentLang = 'en';

// Переключение языка EN <-> RU по клику на кнопку в шапке
function toggleLanguage() {
  currentLang = currentLang === 'en' ? 'ru' : 'en';
  updateContent();
  updatePrograms();
  updateWhy();
  updateToggleButton();
  
  // Обновляем атрибут lang у тега <html> (правильная семантика страницы)
  document.documentElement.lang = currentLang;
}

// Заменяет текст всех элементов с атрибутом data-i18n="ключ"
// на перевод под текущий язык.
// ВАЖНО: используется innerHTML, а не textContent — так HTML-теги
// из TinyMCE (about_content) не разрушаются.
function updateContent() {
  const elements = document.querySelectorAll('[data-i18n]');
  elements.forEach(el => {
    const key = el.getAttribute('data-i18n');
    if (translations[currentLang][key]) {
      el.innerHTML = translations[currentLang][key];
    }
  });
}

// Обновляет карточки программ (Программы) под текущий язык.
// Данные приходят из массива keiserPrograms (header.php),
// порядок карточек на странице соответствует порядку массива.
function updatePrograms() {
  const programCards = document.querySelectorAll('.program-card');
  programCards.forEach((card, index) => {
    if (keiserPrograms[index]) {
      const program = keiserPrograms[index];
      const titleEl = card.querySelector('.program-card__title');
      const descEl = card.querySelector('.program-card__text');
      const btnEl = card.querySelector('.btn');
      
      if (titleEl) titleEl.textContent = program['title_' + currentLang];
      if (descEl) descEl.textContent = program['desc_' + currentLang];
      if (btnEl) btnEl.textContent = program['btn_' + currentLang];
    }
  });
}

// Обновляет блок «Почему мы» под текущий язык
// (по аналогии с программами — из массива keiserWhy).
function updateWhy() {
  const whyItems = document.querySelectorAll('.why-us__item');
  whyItems.forEach((item, index) => {
    if (keiserWhy[index]) {
      const why = keiserWhy[index];
      const titleEl = item.querySelector('.why-us__item-title');
      const descEl = item.querySelector('.why-us__item-text');
      
      if (titleEl) titleEl.textContent = why['title_' + currentLang];
      if (descEl) descEl.textContent = why['desc_' + currentLang];
    }
  });
}

// Обновляет подписи кнопки переключения языка (какой язык активен)
function updateToggleButton() {
  const toggle = document.getElementById('langToggle');
  const current = toggle.querySelector('.lang-toggle__current');
  const other = toggle.querySelector('.lang-toggle__other');
  
  current.textContent = currentLang.toUpperCase();
  other.textContent = currentLang === 'en' ? 'RU' : 'EN';
}

// Отправка события клика по CTA-кнопке в Google Tag Manager.
// Событие попадает в dataLayer, если контейнер GTM подключён.
function trackCTAClick(goal) {
  if (typeof dataLayer !== 'undefined') {
    dataLayer.push({
      'event': 'cta_click',
      'goal': goal,           // какая кнопка нажата (data-goal из HTML)
      'language': currentLang // на каком языке был сайт
    });
  }
}

// Инициализация после загрузки DOM
document.addEventListener('DOMContentLoaded', function() {
  // Навешиваем обработчик на кнопку переключения языка
  const langToggle = document.getElementById('langToggle');
  langToggle.addEventListener('click', toggleLanguage);
  
  // Навешиваем трекинг на все CTA-ссылки (класс .cta-link)
  const ctaLinks = document.querySelectorAll('.cta-link');
  ctaLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      const goal = this.getAttribute('data-goal');
      trackCTAClick(goal);
    });
  });
});
