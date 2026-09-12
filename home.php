<?php
/**
 * home.php — главная страница сайта (шаблон «Home»).
 *
 * Все тексты берутся из Carbon Fields (админка → Внешний вид →
 * Редактирование полей) и по умолчанию выводятся на английском.
 * Переключение на русский выполняет JS (keiser.js) по атрибутам data-i18n.
 *
 * Каждая кнопка ведёт на /?offer=Keiser&sub1=... — этот переход
 * перехватывает backend.php, записывает клик в БД и делает
 * редирект на официальный сайт.
 */

/*
Template Name: Home
*/
?>
<?php get_header(); // шапка сайта ?>

<!-- Секция Hero: главный экран с заголовком, подзаголовком и кнопкой -->
<section class="hero">
  <div class="container">
    <div class="hero__content">
      <h1 class="hero__title" data-i18n="hero_title"><?php echo carbon_get_theme_option('hero_title_en'); ?></h1>
      <p class="hero__subtitle" data-i18n="hero_subtitle"><?php echo carbon_get_theme_option('hero_subtitle_en'); ?></p>
      <a href="<?php echo home_url('/?offer=Keiser&sub1=hero_cta'); ?>" class="btn btn--primary cta-link" data-i18n="hero_cta" data-goal="hero_cta_click"><?php echo carbon_get_theme_option('hero_cta_en'); ?></a>
    </div>
  </div>
</section>

<!-- Секция Программы: сетка карточек из повторяемого поля programs_items -->
<section class="programs">
  <div class="container">
    <h2 class="section-title" data-i18n="programs_title"><?php echo carbon_get_theme_option('programs_title_en'); ?></h2>
    <div class="programs__grid">
      <?php $programs = carbon_get_theme_option('programs_items'); ?>
      <?php if ($programs) : ?>
        <?php foreach ($programs as $program) : ?>
          <div class="program-card">
            <?php if ($program['image']) : ?>
              <!-- Если картинка задана — выводим её -->
              <div class="program-card__img">
                <img src="<?php echo wp_get_attachment_image_url($program['image'], 'full'); ?>" alt="<?php echo $program['title_en']; ?>">
              </div>
            <?php else : ?>
              <!-- Если картинки нет — показываем иконку-заглушку -->
              <div class="program-card__icon">🎓</div>
            <?php endif; ?>
            <h3 class="program-card__title" data-i18n="program_title"><?php echo $program['title_en']; ?></h3>
            <p class="program-card__text" data-i18n="program_desc"><?php echo $program['desc_en']; ?></p>
            <a href="<?php echo home_url('/?offer=Keiser&sub1=program'); ?>" class="btn btn--outline cta-link" data-i18n="program_btn" data-goal="program_cta_click"><?php echo $program['btn_en']; ?></a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Секция «Почему мы»: нумерованные преимущества из why_items -->
<section class="why-us">
  <div class="container">
    <h2 class="section-title section-title--light" data-i18n="why_title"><?php echo carbon_get_theme_option('why_title_en'); ?></h2>
    <div class="why-us__grid">
      <?php $why_items = carbon_get_theme_option('why_items'); ?>
      <?php if ($why_items) : ?>
        <?php $counter = 1; // счётчик для номеров преимуществ ?>
        <?php foreach ($why_items as $item) : ?>
          <div class="why-us__item">
            <div class="why-us__number"><?php echo $counter; ?></div>
            <h3 class="why-us__item-title" data-i18n="why_item_title"><?php echo $item['title_en']; ?></h3>
            <p class="why-us__item-text" data-i18n="why_item_desc"><?php echo $item['desc_en']; ?></p>
          </div>
          <?php $counter++; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <a href="<?php echo home_url('/?offer=Keiser&sub1=why_cta'); ?>" class="btn btn--white cta-link" data-i18n="why_cta" data-goal="why_cta_click"><?php echo carbon_get_theme_option('why_cta_en'); ?></a>
  </div>
</section>

<!-- Секция «О нас»: галерея картинок слева + редактируемый rich-текст справа -->
<section class="about">
  <div class="container">
    <div class="about__grid">
      <div class="about__images">
        <?php $about_images = carbon_get_theme_option('about_images'); ?>
        <?php if ($about_images) : ?>
          <?php foreach ($about_images as $img) : ?>
            <?php if ($img['image']) : ?>
              <div class="about__img">
                <img src="<?php echo wp_get_attachment_image_url($img['image'], 'full'); ?>" alt="">
              </div>
            <?php else : ?>
              <!-- Заглушка, если картинка не выбрана -->
              <div class="about__img">🏫</div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="about__content">
        <!-- Один большой TinyMCE-блок: HTML с заголовком и абзацами -->
        <div data-i18n="about_content"><?php echo carbon_get_theme_option('about_content_en'); ?></div>
      </div>
    </div>
  </div>
</section>

<!-- Средняя CTA-кнопка (нередактируемая: текст меняется только по языку) -->
<section class="cta-button-section">
  <div class="container">
    <a href="<?php echo home_url('/?offer=Keiser&sub1=mid_cta'); ?>" class="btn btn--primary btn--large cta-link" data-i18n="mid_cta" data-goal="mid_cta_click">Start Today</a>
  </div>
</section>

<!-- Секция Видео: заголовок (двуязычный) + iframe (общий для обоих языков) -->
<section class="video-section">
  <div class="container video-section__container">
    <h2 class="video-section__title" data-i18n="video_title"><?php echo carbon_get_theme_option('video_title_en'); ?></h2>
    <div class="video-section__embed">
      <!-- Соотношение сторон 16:9 задаёт CSS (.video-section__ratio) -->
      <div class="video-section__ratio"><?php echo carbon_get_theme_option('video_embed'); ?></div>
    </div>
  </div>
</section>

<!-- Финальная CTA-секция: заголовок, текст и кнопка (все редактируемые) -->
<section class="cta-section">
  <div class="container">
    <h2 class="cta-section__title" data-i18n="cta_title"><?php echo carbon_get_theme_option('cta_title_en'); ?></h2>
    <p class="cta-section__text" data-i18n="cta_text"><?php echo carbon_get_theme_option('cta_text_en'); ?></p>
    <a href="<?php echo home_url('/?offer=Keiser&sub1=main_cta'); ?>" class="btn btn--primary btn--large cta-link" data-i18n="cta_button" data-goal="main_cta_click"><?php echo carbon_get_theme_option('cta_btn_en'); ?></a>
  </div>
</section>

<?php get_footer(); // подвал сайта ?>
