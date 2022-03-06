Php Support System Projesi (Ticket Sistemi)

Setup
-- İlk olarak install.php otomatik çalışacak ve gerekli bilgileri girmelisiniz.
-- Yüklendikten sonra admin kısmından girdiğiniz mail ve şifre ile giriş yapın
-- önce kategorileri oluşturun ve sonra yetkili eklemek için kullanıcı kısmından istediğiniz departmana ekleme yapın
-- eklediğiniz kullanıcı ile giriş yapmak için sağ taraf profilden çıkış kısmına basın
-- Yine profile tıklayarak Site ismi yani title,Admin ismi, profil fotoğrafı vs gibi şeyler değiştirilebilir
-- Smtp ayarları aktif edilmedi ama eklendi mantık şu şekilde swift mailer ile ticket geldiği veya cevaplandığı zaman mail gönderim işlevi yapacak
-- Yazı ve makale kısmı sıkça sorulan sorula şeklinde de kullanılabilir.



Api kısmı (restful)
-- login.php (permission mantığı ile yapılan kullanıcı girişi admin için varsayılmıştır.)
-- ticket_list.php
-- ticket_replay.php
-- ticket_update.php
-- ticket.php


Config Dosyamız
. Config dosyamız içerisinde install işleminden sonra database.php dosyamız oluşturulacak ve içerisinde veritabanı bağlantı bilgileri olacak


Libs Dosyamız
. Özellikle composer üzerinden swift mailer kısmı kullanılabilir ama smtp modülü sunucu üzerinde aktif olacaktır kodlarda yorum satırı olarak gösterildi
. autoload ile kütüphaneler sisteme tanımlanıyor. Tanımlandığı yer: connection.php -> "require_once __DIR__ . "/libs/vendor/autoload.php";"

Upload Dosyası
. Eğer ticket içerisinde bir dosya gönderilecekse numaralandırılarak uploads klasörüne yüklenir.


 PHP dosyalarımız 

admin-security.php
. admin yetkilendirilmesi tanımlanmak için yapılmıştır session kontrolü ile oturum kontrolü sağlandı.





YETKİLENDİRME -->
-- Öncelikle admin ve yetkili girişi farklıdır.
-- kullanıcı giriş yapmayacak ticket gönderecek şekilde ayarlandı.
-- admin tüm yetkilere hakimdir kullanıcı ekleyebilir 
-- **Lütfen öncelikle kategoriler kısmından departmanların kategorilerini oluşturun
-- yetkili departmanın kategorisi seçilir, örneğin mobil ise mobil web ise web seçilmelidir.
-- 


https://summernote.org/ // summernote kısmı ile veri ekleme yolu kullanıldı

<textarea data-provide="summernote" name="description" data-height="300px"></textarea>


// selectpicker ile seçme işlemleri
<select title="Kategori Seç" name="category" data-provide="selectpicker" data-width="100%" required>


// datapicker ile tarih kontrolü sağlandı.
<input class="form-control" type="text" name="publish_date" required placeholder="Şu an" data-provide="datepicker">




Bazı Taktikler : 

*** Article daha çok yazı ve makale gibi konuldu ama Sıkça sorulan sorular şekline de dönüştürülebilir sonradan aklıma geldi.

<?php echo $db->admin['permission']; ?>

if (echo $db->admin['permission']; == "2") // burada numaralandırma ile doğrudan kategorize edilebilir.

if (echo $db->admin['permission']; == "admin") // bu admin kontrolü sağlıyor

if (echo $db->admin['permission']; == "Mobil") // mesela mobil departman
if (echo $db->admin['permission']; == "web") // web departman


. aslında kategorize olması için numaralandırma yerine teknik terimler kullanılabilir. 

. oluşturulan kategorilere göre de gösterim permission sistemi tanımlanır.

. kategoriler ile kullanıcının permission sistemi eşitse olabilir.

. yetkilendirme için dosya gösterim sistemi kullanılabilir.





// Burada permission yetkilendirme için kullanılacak.
 Örneğin satış departmanı destekler olarak sadece satış ile ilgili destekleri görecek

Admin Tablosu
name: admin
-- id (primary key + auto_increments)
-- username 
-- password 
-- permission (bu sütun ile category tablosundaki id sütununu bağlayacağız ve yetkilendirmeyi kategoriye göre yapacağız.)
-- publish_date
-- datetime



// Kategori renkleri durumu ifade etmek için örneğin : kırmızı kapalı destek için gösterilecek 
Kategori Tablosu
name= category
-- id  (primary key + auto_increments)
-- category
-- color
-- is_deleted


//
Ticket Tablosu
name=ticket
-- id (primary key + auto_increments)
-- name
-- email
-- category
-- subject
-- description
-- attachments
-- status
-- datetime
-- is_deleted


Yazılar Tablosu
name=articles
-- id (primary key + auto_increments)
-- title
-- description
-- category
-- publish_date
-- datetime
-- is_deleted


Config Tablosu
name=config
-- config_name
-- config_value





