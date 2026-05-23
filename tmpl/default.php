<?php
defined('_JEXEC') or die;
use Joomla\CMS\Router\Route;


?>

<div class="gallery-grid">
    <?php foreach ($all_items as $item) : ?>
        <?php /*
        echo '<pre>';
        print_r($item);
        echo '</pre>';
        exit();*/
        ?>
         <?php
        $image = !empty($item['full_path_photo']) ? $item['full_path_photo'] : '';
        $title = !empty($item['title']) ? $item['title'] : '';
        $name = !empty($item['name']) ? $item['name'] : '';
        $award = !empty($item['award']) ? $item['award'] : '';
       /* var_dump($name);
        var_dump($award);
        exit();*/
        
        ?>
      


        <div class="gallery-card">
            <?php if ($image) : ?>
            <img src="<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>" 
     alt="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
     onclick="openLightbox(this.src, '<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>')" />
            <?php endif; ?>
            
             <div class="gallery-card-info">
             <?php if ($title) : ?>
                <h3 class='gallery-card-title'><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h3>
             <?php endif; ?>
            
             <?php if ($name) : ?>
                <h3 class='gallery-card-name'><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></h3>
             <?php endif; ?>
            
            <?php if ($award) : ?>
             <div class="gallery-card-awards">
             <?php foreach ($award as $a) : ?>
                    <span class="gallery-card-award"><?php echo htmlspecialchars($a, ENT_QUOTES, 'UTF-8'); ?></span>
              <?php endforeach; ?>
            </div>
           <?php endif; ?>
            </div>
        </div>
       
    <?php endforeach; ?>
     <div class="gallery-lightbox" id="gallery-lightbox" onclick="closeLightbox()">
     <button class="gallery-lightbox-close" onclick="closeLightbox()" aria-label="Close">&times;</button>
     <div class="gallery-lightbox-inner">
       <img id="lightbox-img" src="" alt="" />
       <div class="gallery-lightbox-info">
         <p class="gallery-lightbox-title" id="lightbox-title"></p>
         <p class="gallery-lightbox-names" id="lightbox-names"></p>
       </div>
     </div>
   </div>
</div>
