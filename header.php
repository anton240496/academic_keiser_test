<!DOCTYPE html>
<!-- header.php — шапка сайта: <head>, аналитика, переводы и сама шапка -->
<html <?php language_attributes(); // атрибут lang текущего языка ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Заголовок вкладки браузера = текст логотипа из админки -->
  <title><?php echo carbon_get_theme_option('logo_text'); ?></title>
  <?php wp_head(); // обязательный хук: стили и скрипты темы ?>
 <!-- Google Tag Manager: загрузка счётчика аналитики -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GT-WFMMHQRM');</script>
  <!-- Конец Google Tag Manager -->
  <!-- Google Analytics (GA4): gtag.js + конфигурация контейнера -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CST0KYB7YV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CST0KYB7YV');
</script>
  <!-- Конец Google Analytics -->
  
  <!-- Переводы из Carbon Fields: PHP вставляет значения полей в JS-объекты.
       keiserTranslations — тексты секций, keiserPrograms/keiserWhy —
       массивы карточек для переключения языков в keiser.js -->
  <script>
    var keiserTranslations = {
    en: {
      hero_title: "<?php echo carbon_get_theme_option('hero_title_en'); ?>",
      hero_subtitle: "<?php echo carbon_get_theme_option('hero_subtitle_en'); ?>",
      hero_cta: "<?php echo carbon_get_theme_option('hero_cta_en'); ?>",
      programs_title: "<?php echo carbon_get_theme_option('programs_title_en'); ?>",
      why_title: "<?php echo carbon_get_theme_option('why_title_en'); ?>",
      why_cta: "<?php echo carbon_get_theme_option('why_cta_en'); ?>",
      about_content: <?php echo json_encode(carbon_get_theme_option('about_content_en')); ?>,
      video_title: <?php echo json_encode(carbon_get_theme_option('video_title_en')); ?>,
      mid_cta: "Start Today",
      cta_title: <?php echo json_encode(carbon_get_theme_option('cta_title_en')); ?>,
      cta_text: <?php echo json_encode(carbon_get_theme_option('cta_text_en')); ?>,
      cta_button: <?php echo json_encode(carbon_get_theme_option('cta_btn_en')); ?>,
      footer_text: <?php echo json_encode(carbon_get_theme_option('footer_text_en')); ?>,
    },
    ru: {
      hero_title: "<?php echo carbon_get_theme_option('hero_title_ru'); ?>",
      hero_subtitle: "<?php echo carbon_get_theme_option('hero_subtitle_ru'); ?>",
      hero_cta: "<?php echo carbon_get_theme_option('hero_cta_ru'); ?>",
      programs_title: "<?php echo carbon_get_theme_option('programs_title_ru'); ?>",
      why_title: "<?php echo carbon_get_theme_option('why_title_ru'); ?>",
      why_cta: "<?php echo carbon_get_theme_option('why_cta_ru'); ?>",
      about_content: <?php echo json_encode(carbon_get_theme_option('about_content_ru')); ?>,
      video_title: <?php echo json_encode(carbon_get_theme_option('video_title_ru')); ?>,
      mid_cta: "Начать сейчас",
      cta_title: <?php echo json_encode(carbon_get_theme_option('cta_title_ru')); ?>,
      cta_text: <?php echo json_encode(carbon_get_theme_option('cta_text_ru')); ?>,
      cta_button: <?php echo json_encode(carbon_get_theme_option('cta_btn_ru')); ?>,
      footer_text: <?php echo json_encode(carbon_get_theme_option('footer_text_ru')); ?>,
    }
    };
    
    // Переводы программ: массив карточек (title/desc/btn в обоих языках),
    // используется keiser.js в функции updatePrograms()
    var keiserPrograms = <?php 
      $programs = carbon_get_theme_option('programs_items');
      $programs_data = [];
      if ($programs) {
        foreach ($programs as $index => $program) {
          $programs_data[] = [
            'title_en' => $program['title_en'],
            'title_ru' => $program['title_ru'],
            'desc_en' => $program['desc_en'],
            'desc_ru' => $program['desc_ru'],
            'btn_en' => $program['btn_en'],
            'btn_ru' => $program['btn_ru'],
          ];
        }
      }
      echo json_encode($programs_data);
    ?>;
    
    // Переводы «Почему мы»: массив преимуществ (title/desc в обоих языках),
    // используется keiser.js в функции updateWhy()
    var keiserWhy = <?php 
      $why_items = carbon_get_theme_option('why_items');
      $why_data = [];
      if ($why_items) {
        foreach ($why_items as $item) {
          $why_data[] = [
            'title_en' => $item['title_en'],
            'title_ru' => $item['title_ru'],
            'desc_en' => $item['desc_en'],
            'desc_ru' => $item['desc_ru'],
          ];
        }
      }
      echo json_encode($why_data);
    ?>;
  </script>
</head>
<body <?php body_class(); ?>>
  <!-- Google Tag Manager (noscript): резервный счётчик для посетителей
       с отключённым JavaScript; ID должен совпадать со скриптом выше -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GT-WFMMHQRM"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- Конец Google Tag Manager (noscript) -->

  <!-- Шапка сайта: логотип (слева) и переключатель языков (справа) -->
  <header class="header">
    <div class="container">
      <div class="header__inner">
        <div class="logo">
          <?php
            $logo_src = carbon_get_theme_option('logo_image');
            // Поле хранит ID вложения (новый формат); поддерживаем и старый URL
            if ($logo_src && is_numeric($logo_src)) {
                $logo_attachment = wp_get_attachment_url($logo_src);
                if ($logo_attachment) { $logo_src = $logo_attachment; }
            }
          ?>
          <?php if ($logo_src) : ?>
            <img class="logo__img" src="<?php echo $logo_src; ?>" alt="<?php echo carbon_get_theme_option('logo_text'); ?>">
          <?php else : ?>
            <span class="logo__icon">KU</span>
          <?php endif; ?>
          <span class="logo__text"><?php echo carbon_get_theme_option('logo_text'); ?></span>
        </div>
        <button class="lang-toggle" id="langToggle">
          <span class="lang-toggle__current">EN</span>
          <span class="lang-toggle__divider">/</span>
          <span class="lang-toggle__other">RU</span>
        </button>
      </div>
    </div>
  </header>

  <main class="main-content">
