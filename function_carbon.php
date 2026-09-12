<?php
/**
 * function_carbon.php — регистрация полей админки (Carbon Fields).
 *
 * Создаёт страницу «Внешний вид → Редактирование полей» с вкладками:
 * Логотип, Hero, Программы, Почему мы, О нас, Видео, CTA, Footer.
 *
 * Значения по умолчанию (set_default_value) показываются в админке,
 * пока поле не заполнено. Все тексты двуязычные: ключи *_en / *_ru.
 * Читаются на сайте через carbon_get_theme_option('ключ').
 */
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Хук Carbon Fields: регистрация полей после инициализации библиотеки
add_action('carbon_fields_register_fields', 'keiser_theme_options');

function keiser_theme_options()
{
    Container::make('theme_options', 'Редактирование полей')
        ->set_page_parent('themes.php')
        ->add_tab('Логотип', [
            Field::make('image', 'logo_image', 'Логотип (картинка)')
                ->set_value_type('id'),
            Field::make('text', 'logo_text', 'Текст логотипа'),
        ])
        ->add_tab('Hero', [
            Field::make('text', 'hero_title_en', 'Заголовок (EN)')
                ->set_default_value('Launch Your Future with Keiser University'),
            Field::make('text', 'hero_title_ru', 'Заголовок (RU)')
                ->set_default_value('Начните своё будущее с Университетом Кейзер'),
            Field::make('text', 'hero_subtitle_en', 'Подзаголовок (EN)')
                ->set_default_value('Career-focused education that fits your life. Start your journey today.'),
            Field::make('text', 'hero_subtitle_ru', 'Подзаголовок (RU)')
                ->set_default_value('Образование, ориентированное на карьеру, которое подходит вашей жизни. Начните свой путь сегодня.'),
            Field::make('text', 'hero_cta_en', 'Кнопка (EN)')
                ->set_default_value('Explore Programs'),
            Field::make('text', 'hero_cta_ru', 'Кнопка (RU)')
                ->set_default_value('Изучить программы'),
        ])
        ->add_tab('Программы', [
            Field::make('text', 'programs_title_en', 'Заголовок секции (EN)')
                ->set_default_value('Our Programs'),
            Field::make('text', 'programs_title_ru', 'Заголовок секции (RU)')
                ->set_default_value('Наши программы'),
            Field::make('complex', 'programs_items', 'Программы')
                ->set_layout('tabbed-horizontal')
                ->add_fields([
                    Field::make('image', 'image', 'Изображение')
                        ->set_value_type('id'),
                    Field::make('text', 'title_en', 'Название (EN)'),
                    Field::make('text', 'title_ru', 'Название (RU)'),
                    Field::make('textarea', 'desc_en', 'Описание (EN)'),
                    Field::make('textarea', 'desc_ru', 'Описание (RU)'),
                    Field::make('text', 'btn_en', 'Кнопка (EN)')
                        ->set_default_value('Learn More'),
                    Field::make('text', 'btn_ru', 'Кнопка (RU)')
                        ->set_default_value('Узнать больше'),
                ])
                ->set_default_value([
                    [
                        'title_en' => 'Nursing',
                        'title_ru' => 'Медицина',
                        'desc_en' => 'Start your career in healthcare with hands-on nursing programs.',
                        'desc_ru' => 'Начните карьеру в здравоохранении с практическими программами обучения.',
                    ],
                    [
                        'title_en' => 'Business',
                        'title_ru' => 'Бизнес',
                        'desc_en' => 'Build your business skills for the modern workplace.',
                        'desc_ru' => 'Развивайте бизнес-навыки для современного рабочего места.',
                    ],
                    [
                        'title_en' => 'Information Technology',
                        'title_ru' => 'Информационные технологии',
                        'desc_en' => 'Master the tech skills that drive today\'s economy.',
                        'desc_ru' => 'Освойте технические навыки, которые движут современной экономикой.',
                    ],
                ]),
        ])
        ->add_tab('Почему мы', [
            Field::make('text', 'why_title_en', 'Заголовок (EN)')
                ->set_default_value('Why Choose Keiser?'),
            Field::make('text', 'why_title_ru', 'Заголовок (RU)')
                ->set_default_value('Почему выбирают Кейзер?'),
            Field::make('complex', 'why_items', 'Шаги')
                ->set_layout('tabbed-horizontal')
                ->add_fields([
                    Field::make('text', 'title_en', 'Заголовок (EN)'),
                    Field::make('text', 'title_ru', 'Заголовок (RU)'),
                    Field::make('textarea', 'desc_en', 'Описание (EN)'),
                    Field::make('textarea', 'desc_ru', 'Описание (RU)'),
                ])
                ->set_default_value([
                    [
                        'title_en' => 'Flexible Scheduling',
                        'title_ru' => 'Гибкий график',
                        'desc_en' => 'Day, evening, and online classes to fit your schedule.',
                        'desc_ru' => 'Дневные, вечерние и онлайн-занятия для вашего удобства.',
                    ],
                    [
                        'title_en' => 'Personalized Support',
                        'title_ru' => 'Индивидуальный подход',
                        'desc_en' => 'Small classes and one-on-one attention from instructors.',
                        'desc_ru' => 'Небольшие группы и личное внимание преподавателей.',
                    ],
                    [
                        'title_en' => 'Career-Focused',
                        'title_ru' => 'Ориентация на карьеру',
                        'desc_en' => 'Hands-on learning designed for real-world success.',
                        'desc_ru' => 'Практическое обучение для реального успеха.',
                    ],
                ]),
            Field::make('text', 'why_cta_en', 'Кнопка (EN)')
                ->set_default_value('Start Your Journey'),
            Field::make('text', 'why_cta_ru', 'Кнопка (RU)')
                ->set_default_value('Начните свой путь'),
        ])
        ->add_tab('О нас', [
            Field::make('complex', 'about_images', 'Картинки')
                ->set_layout('tabbed-horizontal')
                ->add_fields([
                    Field::make('image', 'image', 'Изображение')
                        ->set_value_type('id'),
                ])
                ->set_default_value([
                    ['image' => ''],
                    ['image' => ''],
                    ['image' => ''],
                ]),
            Field::make('rich_text', 'about_content_en', 'Описание (EN)')
                ->set_default_value('<h2 class="about__title">About Keiser University</h2><p class="about__text">Founded in 1977, Keiser University is a private, not-for-profit institution offering career-focused education.</p><p class="about__text">With campuses across Florida and online programs, we serve students worldwide.</p><p class="about__text">Our mission is to provide students with the skills and knowledge needed for successful careers.</p>'),
            Field::make('rich_text', 'about_content_ru', 'Описание (RU)')
                ->set_default_value('<h2 class="about__title">Об Университете Кейзер</h2><p class="about__text">Основанный в 1977 году, Университет Кейзер — частное некоммерческое учебное заведение, предлагающее образование, ориентированное на карьеру.</p><p class="about__text">С кампусами по всей Флориде и онлайн-программами мы обслуживаем студентов по всему миру.</p><p class="about__text">Наша миссия — предоставить студентам навыки и знания, необходимые для успешной карьеры.</p>'),
        ])
        ->add_tab('Видео', [
            Field::make('text', 'video_title_en', 'Заголовок (EN)')
                ->set_default_value('Student Success Stories'),
            Field::make('text', 'video_title_ru', 'Заголовок (RU)')
                ->set_default_value('Истории успеха студентов'),
            Field::make('textarea', 'video_embed', 'Видео iframe')
                ->set_default_value('<iframe width="1163" height="654" src="https://www.youtube.com/embed/6LIpFibUrww" title="Истории успеха" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>'),
        ])
        ->add_tab('CTA', [
            Field::make('text', 'cta_title_en', 'Заголовок (EN)')
                ->set_default_value('Ready to Start?'),
            Field::make('text', 'cta_title_ru', 'Заголовок (RU)')
                ->set_default_value('Готовы начать?'),
            Field::make('text', 'cta_text_en', 'Текст (EN)')
                ->set_default_value('Join thousands of students who chose Keiser University.'),
            Field::make('text', 'cta_text_ru', 'Текст (RU)')
                ->set_default_value('Присоединяйтесь к тысячам студентов, выбравших Университет Кейзер.'),
            Field::make('text', 'cta_btn_en', 'Кнопка (EN)')
                ->set_default_value('Apply Now'),
            Field::make('text', 'cta_btn_ru', 'Кнопка (RU)')
                ->set_default_value('Подать заявку'),
        ])
        ->add_tab('Footer', [
            Field::make('text', 'footer_text_en', 'Текст footer (EN)')
                ->set_default_value('Keiser University. All rights reserved.'),
            Field::make('text', 'footer_text_ru', 'Текст footer (RU)')
                ->set_default_value('Университет Кейзер. Все права защищены.'),
        ]);
}