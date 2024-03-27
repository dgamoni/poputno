<?php
/*
* Template Name: Редактирование ваканисии
*/


if (!is_user_logged_in()) {
    wp_redirect('/');
}


global $current_user, $post;
get_currentuserinfo();
$author_id = get_the_author_meta('ID', $current_user->id);

?>

<?php get_header(); ?>

<section class="main" id="main">

<div class="wrap cf">

<div class="post">
<h1>Добавить вакансию</h1>


<div id="univac-form">

<div class="univac_step_one_msg"><p>C помощью этой формы вы можете <strong>бесплатно</strong> разместить
        вакансию на сайте AIN.UA. После модерации информация будет опубликована в соответствующем <a
            href="http://ain.ua/jobs">разделе</a>.</p>

    <p>Рекомендуем вам поучаствовать в распространении информации и рассказать о вакансии друзьям в
        социальных сетях, используя <a href="http://ain.ua/wp-content/uploads/2012/02/jobbuttons.png">соответствующие
            кнопки</a>.</p>

    <p>Обращаем внимание, что если вы добавите логотип компании, то вакансия также попадет в ротацию в
        блок с топ-вакансиями на главной странице.</p>

    <p>Если же вы хотите <strong>добиться большей эффективности</strong>, есть возможность коммерческого
        размещения (2000 грн). В этом случае вакансия будет дополнительно опубликована на главной
        странице, в ленте новостей, а также будет отправлена в социальные сети</p>

    <p>Заказать коммерческое размещение можно по контактам, указанным на странице <a
            href="http://ain.ua/adv">Реклама на AIN.UA</a></p></div>

<div class="univac-breadcrumbs">
    <div class="univac-breadcrumbs-active"><p>Данные вакансии</p></div>
    <div class="univac-breadcrumbs-inactive"><p>Предварительный просмотр</p></div>
</div>
<div class="clear"></div>


<form id="vacancy-form" method="POST" enctype="multipart/form-data">

<input type="hidden" name="step" value="2">
<label>Название вакансии</label><input type="text" name="title" value="">

<label>Описание (макс. 5000 знаков)</label>

<div id="wp-description-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
    <link rel="stylesheet" id="editor-buttons-css"
          href="http://ain.ua/wp-includes/css/editor.min.css?ver=3.9.1" type="text/css" media="all">
    <div id="wp-description-editor-tools" class="wp-editor-tools hide-if-no-js">
        <div class="wp-editor-tabs"><a id="description-html" class="wp-switch-editor switch-html"
                                       onclick="switchEditors.switchto(this);">Текст</a>
            <a id="description-tmce" class="wp-switch-editor switch-tmce"
               onclick="switchEditors.switchto(this);">Визуально</a>
        </div>
    </div>
    <div id="wp-description-editor-container" class="wp-editor-container">
        <div id="qt_description_toolbar" class="quicktags-toolbar"><input type="button"
                                                                          id="qt_description_strong"
                                                                          accesskey="b"
                                                                          class="ed_button button button-small"
                                                                          title="" value="b"><input
                type="button" id="qt_description_em" accesskey="i"
                class="ed_button button button-small" title="" value="i"><input type="button"
                                                                                id="qt_description_link"
                                                                                accesskey="a"
                                                                                class="ed_button button button-small"
                                                                                title=""
                                                                                value="link"><input
                type="button" id="qt_description_block" accesskey="q"
                class="ed_button button button-small" title="" value="b-quote"><input type="button"
                                                                                      id="qt_description_del"
                                                                                      accesskey="d"
                                                                                      class="ed_button button button-small"
                                                                                      title=""
                                                                                      value="del"><input
                type="button" id="qt_description_ins" accesskey="s"
                class="ed_button button button-small" title="" value="ins"><input type="button"
                                                                                  id="qt_description_img"
                                                                                  accesskey="m"
                                                                                  class="ed_button button button-small"
                                                                                  title=""
                                                                                  value="img"><input
                type="button" id="qt_description_ul" accesskey="u"
                class="ed_button button button-small" title="" value="ul">
            <input type="button"
                   id="qt_description_ol"
                   accesskey="o"
                   class="ed_button button button-small"
                   title=""
                   value="ol"><input
                type="button" id="qt_description_li" accesskey="l"
                class="ed_button button button-small" title="" value="li"><input type="button"
                                                                                 id="qt_description_code"
                                                                                 accesskey="c"
                                                                                 class="ed_button button button-small"
                                                                                 title=""
                                                                                 value="code"><input
                type="button" id="qt_description_more" accesskey="t"
                class="ed_button button button-small" title="" value="more"><input type="button"
                                                                                   id="qt_description_close"
                                                                                   class="ed_button button button-small"
                                                                                   title="Закрыть все открытые теги"
                                                                                   value="закрыть теги">
        </div>
        <div id="mce_21" class="mce-tinymce mce-container mce-panel" hidefocus="1" tabindex="-1"
             role="application" style="visibility: hidden; border-width: 1px;">
            <div id="mce_21-body" class="mce-container-body mce-stack-layout">
                <div id="mce_22"
                     class="mce-toolbar-grp mce-container mce-panel mce-first mce-stack-layout-item"
                     hidefocus="1" tabindex="-1" role="group">
                    <div id="mce_22-body" class="mce-container-body mce-stack-layout">
                        <div id="mce_23"
                             class="mce-container mce-toolbar mce-first mce-last mce-stack-layout-item"
                             role="toolbar">
                            <div id="mce_23-body" class="mce-container-body mce-flow-layout">
                                <div id="mce_24"
                                     class="mce-container mce-first mce-last mce-flow-layout-item mce-btn-group"
                                     role="group">
                                    <div id="mce_24-body">
                                        <div id="mce_6" class="mce-widget mce-btn mce-first"
                                             tabindex="-1" aria-labelledby="mce_6" role="button"
                                             aria-label="Bold">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-bold"></i></button>
                                        </div>
                                        <div id="mce_7" class="mce-widget mce-btn" tabindex="-1"
                                             aria-labelledby="mce_7" role="button"
                                             aria-label="Italic">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-italic"></i></button>
                                        </div>
                                        <div id="mce_8" class="mce-widget mce-btn" tabindex="-1"
                                             aria-labelledby="mce_8" role="button"
                                             aria-label="Underline">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-underline"></i></button>
                                        </div>
                                        <div id="mce_9" class="mce-widget mce-btn" tabindex="-1"
                                             aria-labelledby="mce_9" role="button"
                                             aria-label="Blockquote">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-blockquote"></i></button>
                                        </div>
                                        <div id="mce_10" class="mce-widget mce-btn" tabindex="-1"
                                             aria-labelledby="mce_10" role="button"
                                             aria-label="Strikethrough">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-strikethrough"></i></button>
                                        </div>
                                        <div id="mce_11" class="mce-widget mce-btn" tabindex="-1"
                                             aria-labelledby="mce_11" role="button"
                                             aria-label="Bullet list">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-bullist"></i></button>
                                        </div>
                                        <div id="mce_12" class="mce-widget mce-btn" tabindex="-1"
                                             aria-labelledby="mce_12" role="button"
                                             aria-label="Numbered list">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-numlist"></i></button>
                                        </div>
                                        <div id="mce_13" class="mce-widget mce-btn" tabindex="-1"
                                             aria-labelledby="mce_13" role="button"
                                             aria-label="Align left">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-alignleft"></i></button>
                                        </div>
                                        <div id="mce_14" class="mce-widget mce-btn" tabindex="-1"
                                             aria-labelledby="mce_14" role="button"
                                             aria-label="Align center">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-aligncenter"></i></button>
                                        </div>
                                        <div id="mce_15" class="mce-widget mce-btn" tabindex="-1"
                                             aria-labelledby="mce_15" role="button"
                                             aria-label="Align right">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-alignright"></i></button>
                                        </div>
                                        <div id="mce_16" class="mce-widget mce-btn mce-disabled"
                                             tabindex="-1" aria-labelledby="mce_16" role="button"
                                             aria-label="Undo" aria-disabled="true">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-undo"></i></button>
                                        </div>
                                        <div id="mce_17" class="mce-widget mce-btn mce-disabled"
                                             tabindex="-1" aria-labelledby="mce_17" role="button"
                                             aria-label="Redo" aria-disabled="true">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-redo"></i></button>
                                        </div>
                                        <div id="mce_18" class="mce-widget mce-btn mce-disabled"
                                             tabindex="-1" aria-labelledby="mce_18" role="button"
                                             aria-label="Insert/edit link" aria-disabled="true"
                                             aria-pressed="null">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-link"></i></button>
                                        </div>
                                        <div id="mce_19" class="mce-widget mce-btn mce-disabled"
                                             tabindex="-1" aria-labelledby="mce_19" role="button"
                                             aria-label="Remove link" aria-disabled="true"
                                             aria-pressed="null">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-unlink"></i></button>
                                        </div>
                                        <div id="mce_20" class="mce-widget mce-btn mce-last"
                                             tabindex="-1" aria-labelledby="mce_20" role="button"
                                             aria-label="Fullscreen">
                                            <button role="presentation" type="button" tabindex="-1">
                                                <i class="mce-ico mce-i-fullscreen"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="mce_25" class="mce-edit-area mce-container mce-panel mce-stack-layout-item"
                     hidefocus="1" tabindex="-1" role="group" style="border-width: 1px 0px 0px;">
                    <iframe id="description_ifr" src='javascript:""' frameborder="0"
                            allowtransparency="true"
                            title="Область редактирования. Alt + F9 — меню. Alt + F10 — панель инструментов. Alt + 0 — помощь."
                            style="width: 100%; height: 150px; display: block;"></iframe>
                </div>
                <div id="mce_26"
                     class="mce-statusbar mce-container mce-panel mce-last mce-stack-layout-item"
                     hidefocus="1" tabindex="-1" role="group" style="border-width: 1px 0px 0px;">
                    <div id="mce_26-body" class="mce-container-body mce-flow-layout">
                        <div id="mce_27" class="mce-path mce-first mce-flow-layout-item">
                            <div role="button" class="mce-path-item mce-last" data-index="0"
                                 tabindex="-1" id="mce_27-0" aria-level="0">p
                            </div>
                        </div>
                        <div id="mce_28" class="mce-last mce-flow-layout-item mce-resizehandle"><i
                                class="mce-ico mce-i-resize"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <textarea class="wp-editor-area" rows="20" autocomplete="off" cols="40" name="description"
                  id="description" style="display: none;" aria-hidden="true"></textarea></div>
</div>


<div class="vac_cat"><label>Категория</label>


    <p id="type_2872" class="form-vac-type"><input type="radio" name="category"
                                                   value="Бизнес"><span>Бизнес</span></p>

    <p id="type_2870" class="form-vac-type"><input type="radio" name="category"
                                                   value="Продажи"><span>Продажи</span></p>

    <p id="type_2868" class="form-vac-type"><input type="radio" name="category"
                                                   value="Реклама и маркетинг"><span>Реклама и маркетинг</span>
    </p>

    <p id="type_2943" class="form-vac-type"><input type="radio" name="category"
                                                   value="Социальные медиа"><span>Социальные медиа</span>
    </p>

    <p id="type_2871" class="form-vac-type"><input type="radio" name="category"
                                                   value="Технологии"><span>Технологии</span></p>
</div>

<div class="vac_type"><label>Вид занятости</label>
    <select name="type">
        <option value="Фуллтайм">Фуллтайм</option>
        <option value="Фриланс">Фриланс</option>
        <option value="Контракт">Контракт</option>
    </select>


    <div class="clear"></div>
</div>
<div id="city-container">
    <label>Город</label><select id="select_city" name="city">
        <option value="Tel-Aviv, Israel">Tel-Aviv, Israel</option>
        <option value="Toronto, Canada">Toronto, Canada</option>
        <option value="Італія">Італія</option>
        <option value="Берлін">Берлін</option>
        <option value="Винница">Винница</option>
        <option value="Днепропетровск">Днепропетровск</option>
        <option value="Донецк">Донецк</option>
        <option value="Житомир">Житомир</option>
        <option value="Запорожье">Запорожье</option>
        <option value="Казань">Казань</option>
        <option value="Киев" selected="">Киев</option>
        <option value="краков">краков</option>
        <option value="Куала Лумпур, Малайзия">Куала Лумпур, Малайзия</option>
        <option value="Луганск">Луганск</option>
        <option value="Луцк">Луцк</option>
        <option value="Львов">Львов</option>
        <option value="любой">любой</option>
        <option value="Любой город">Любой город</option>
        <option value="Москва">Москва</option>
        <option value="Николаев">Николаев</option>
        <option value="Одесса">Одесса</option>
        <option value="Севастополь">Севастополь</option>
        <option value="Симферополь">Симферополь</option>
        <option value="Суммы">Суммы</option>
        <option value="Феодосия">Феодосия</option>
        <option value="Харьков">Харьков</option>
        <option value="Херсон">Херсон</option>
        <option value="Хмельницкий">Хмельницкий</option>
        <option value="Черкассы">Черкассы</option>
        <option value="Чернигов">Чернигов</option>
        <option value="Черновцы">Черновцы</option>
        <option value="Ялта">Ялта</option>
        <option value="other">Другой</option>
    </select>
</div>
<div id="other-city-container" style="display: none;">
    <label>Если "Другой", укажите:</label><input type="text" name="other-city" value="">
</div>

<label style="clear:both;">Зарплата</label><input type="text" name="salary" value=""> грн / мес.
<label>Контактная информация</label><textarea name="contacts"></textarea>

<label class="vac_inp">Название компании<input type="text" name="company_name" value=""></label>
<label class="vac_inp">Сайт<input type="text" name="company_site" value=""></label>
<label>Описание</label><textarea name="company_description"></textarea>


<label>Логотип <i>(мин.ширина: 220px)</i></label><input type="file" name="logo">

<p class="infoaboutvac">Ваша вакансия будет размещена на сайте на 30 дней. По желанию, Вы в любой
    момент сможете её самостоятельно закрыть.</p>

<input class="blink" type="submit" value="Далее">

</form>

<div class="clear"></div>
</div>


<hr>
</div>

<?php get_sidebar(); ?>
</div>
</section>

<?php get_footer(); ?>
