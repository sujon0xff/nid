<?php
// ID কার্ডের জন্য URL এবং টেমপ্লেট
$image_url = isset($_GET['img']) ? htmlspecialchars($_GET['img']) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRFq9Jr55blqVagearfl4qecKC-ek9Bdu2UAA&s';

// Fake Nid Making Clone
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'শরিফা আফা';
$name_en = isset($_GET['name_en']) ? htmlspecialchars($_GET['name_en']) : 'sorif';
$baba = isset($_GET['baba']) ? htmlspecialchars($_GET['baba']) : 'আভাল';
$mom = isset($_GET['mom']) ? htmlspecialchars($_GET['mom']) : 'শরিফা বেগম';
$birth = isset($_GET['birth']) ? htmlspecialchars($_GET['birth']) : '10 oct 2000';
$nid = isset($_GET['nid']) ? htmlspecialchars($_GET['nid']) : '89999999999';
$hold = isset($_GET['hold']) ? htmlspecialchars($_GET['hold']) : '300';
$address = isset($_GET['address']) ? htmlspecialchars($_GET['address']) : 'চোদন, পারা, ধনখারা';
$sex = isset($_GET['sex']) ? htmlspecialchars($_GET['sex']) : 'A+';

$dakgor = isset($_GET['dakgor']) ? htmlspecialchars($_GET['dakgor']) : 'চোদন পারা+';

$signature = isset($_GET['signature']) ? htmlspecialchars($_GET['signature']) : 'Sorifa';

// ছবিতে টেক্সট যোগ করার ফাংশন
function addTextToImage($image, $text, $font_size, $x, $y, $color, $font_path) {
    imagettftext($image, $font_size, 0, $x, $y, $color, $font_path, $text);
}

// একটি URL থেকে ছবি লোড করার ফাংশন
function loadImage($image_url) {
    $image_info = getimagesize($image_url);
    $image_type = $image_info[2];

    switch ($image_type) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($image_url);
        case IMAGETYPE_PNG:
            return imagecreatefrompng($image_url);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($image_url);
        default:
            return false;
    }
}

// ছবিতে ওভারলে এবং টেক্সট যোগ করার ফাংশন
function overlayImageFromURL($template_image_path, $uploaded_image_url, $name, $name_en, $baba, $mom, $birth, $nid, $hold, $address, $sex, $dakgor, $signature) {
    $template = imagecreatefromjpeg($template_image_path);

    if ($template === false) {
        die('Template image লোড হতে পারছে না');
    }

    $uploaded_image = loadImage($uploaded_image_url);

    if ($uploaded_image === false) {
        die('কোনো বৈধ ইমেজ URL প্রদান করা হয়নি');
    }

    // আপলোড করা ছবিটি আকারে পরিবর্তন করা
    $uploaded_image = imagescale($uploaded_image, 223, 230);

    // টেক্সট এবং বর্ডারের জন্য রঙ বরাদ্দ করা
    $black = imagecolorallocate($template, 0, 0, 0);
    $red = imagecolorallocate($template, 255, 0, 0);

    // গোলাকার প্রান্তের ছবিটি টেমপ্লেটে কপি করা
    imagecopy($template, $uploaded_image, 59, 280, 0, 0, imagesx($uploaded_image), imagesy($uploaded_image));

    
    $font_path = __DIR__ . '/roboto.ttf';
    $font_path2 = __DIR__ . '/kalpurush.ttf';
        $font_path3 = __DIR__ . '/Roboto-Regular.ttf';
                $font_path4 = __DIR__ . '/Signature.ttf';

   
    addTextToImage($template, $name, 34, 403, 310, $black, $font_path2);
    addTextToImage($template, $name_en, 34, 403, 370, $black, $font_path3);
    addTextToImage($template, $baba, 34, 407, 436, $black, $font_path2);
    addTextToImage($template, $mom, 34, 407, 496, $black, $font_path2);
    addTextToImage($template, $birth, 30, 570, 559, $red, $font_path);
    addTextToImage($template, $nid, 45, 470, 638, $red, $font_path);
    
    
    addTextToImage($template, $hold, 25, 310, 970, $black, $font_path3);
    
    addTextToImage($template, $address, 25, 500, 970, $black, $font_path2);
    
    addTextToImage($template, $sex, 31, 410, 1112, $red, $font_path);
   
   addTextToImage($template, $dakgor, 28, 240, 1010, $black, $font_path2);
    
    addTextToImage($template, $signature, 40, 120, 590, $black, $font_path4);
    


    
    header('Content-Type: image/jpeg');
    imagejpeg($template);

    imagedestroy($template);
    imagedestroy($uploaded_image);
}


$template_image = 'https://i.ibb.co.com/JkJLjRM/ss.jpg';

// ID কার্ড তৈরি করা
overlayImageFromURL($template_image, $image_url, $name, $name_en, $baba, $mom, $birth, $nid, $hold, $address, $sex, $dakgor, $signature);
?>
