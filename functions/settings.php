<?php
class ControlPanel {
// Устанавливаем значения по умолчанию
var $default_settings = array(
 'phone' => '+7 (49143) 5-04-25',
 'email' => 'korablino@ryazangov.ru'
 );
 var $options;

 function ControlPanel() {
 add_action('admin_menu', array(&$this, 'add_menu'));
 if (!is_array(get_option('themadmin')))
 add_option('themadmin', $this->default_settings);
 $this->options = get_option('themadmin');
 }

 function add_menu() {
 add_theme_page('WP Theme Options', 'Опции темы', 8, "themadmin", array(&$this, 'optionsmenu'));
 }

 // Сохраняем значения формы с настройками
 function optionsmenu() {
 if ($_POST['ss_action'] == 'save') {
 $this->options["phone"] = $_POST['cp_phone'];
 $this->options["email"] = $_POST['cp_email'];
 $this->options["anounce"] = $_POST['cp_cat-anounce'];
 $this->options["news"] = $_POST['cp_cat-news'];
 $this->options["video"] = $_POST['cp_cat-video'];
 $this->options["gallery"] = $_POST['cp_cat-gallery'];
 $this->options["facebook"] = $_POST['cp_facebook'];
 $this->options["vkontakte"] = $_POST['cp_vkontakte'];
 $this->options["twitter"] = $_POST['cp_twitter'];
 $this->options["metrika"] = $_POST['cp_metrika'];
 update_option('themadmin', $this->options);
 echo '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width: 400px; margin-left: 17px; margin-top: 17px;"><p>Ваши изменения <strong>сохранены</strong>.</p></div>';
 }
 // Создаем форму для настроек
 echo '<form action="" method="post" class="themeform">';
 echo '<input type="hidden" id="ss_action" name="ss_action" value="save">';

 print '<div class="cptab"><br />
 <b>Настройки темы</b>
 <br />
 <h3>Контакты</h3>
 <p><input placeholder="Телефон" style="width:300px;" name="cp_phone" id="cp_phone" value="'.$this->options["phone"].'"><label> - телефон</label></p>
 <p><input placeholder="Email" style="width:300px;" name="cp_email" id="cp_email" value="'.$this->options["email"].'"><label> - email</label></p>

 <h3>Настройки главной страницы</h3>
<p><input placeholder="Объявления" style="width:300px;" name="cp_cat-anounce" id="cp_cat-anounce" value="'.$this->options["anounce"].'"><label> - id категории для ссылки заголовка <strong>"Объявления"</strong></label></p>
 <p><input placeholder="Новости" style="width:300px;" name="cp_cat-news" id="cp_cat-news" value="'.$this->options["news"].'"><label> - id категории для ссылки заголовка <strong>"Новости"</strong></label></p>
 <p><input placeholder="Видео" style="width:300px;" name="cp_cat-video" id="cp_cat-video" value="'.$this->options["video"].'"><label> - id категории для ссылки заголовка <strong>"Видео"</strong></label></p>
  <p><input placeholder="Фотогалерея" style="width:300px;" name="cp_cat-gallery" id="cp_cat-gallery" value="'.$this->options["gallery"].'"><label> - id категории (несколько категорий - через запятую) для ссылки заголовка <strong>"Избранные рубрики" </strong> <br> (указать категории, содержащие галереи или фотографии)</label></p>

 <h3>Социальные сети</h3>
 <p><input placeholder="Ссылка на страницу facebook" style="width:300px;" name="cp_facebook" id="cp_facebook" value="'.$this->options["facebook"].'"><label> - facebook</label></p>
 <p><input placeholder="Ссылка на страницу vkontakte" style="width:300px;" name="cp_vkontakte" id="cp_vkontakte" value="'.$this->options["vkontakte"].'"><label> - vkontakte</label></p>
 <p><input placeholder="Ссылка на страницу twitter" style="width:300px;" name="cp_twitter" id="cp_twitter" value="'.$this->options["twitter"].'"><label> - twitter</label></p>

 <h3>Код в footer.php</h3>
 <p><textarea placeholder="Здесь можно прописать коды счетчиков или дополнительных скриптов" style="width:300px;" name="cp_metrika" id="cp_metrika">'.stripslashes($this->options["metrika"]).'</textarea><label> - здесь можно прописать коды счетчиков или дополнительных скриптов</label></p>

 </div><br />';
 echo '<input type="submit" value="Сохранить" name="cp_save" class="dochanges" />';
 echo '</form>';
 }
}
$cpanel = new ControlPanel();
$themeoptions = get_option('themadmin');
?>
