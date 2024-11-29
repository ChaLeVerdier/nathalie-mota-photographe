<div id="modal-contact" class="modal-contact hidden">
    <!-- Conteneur principal de la modal -->
    <div class="modal-contact-content">
        
        <!-- Image d'en-tête non modifiable -->
        <div class="modal-header">
            <img 
                src="<?php echo get_template_directory_uri(); ?>/assets/images/contact-header.png" 
                alt="En-tête de la modal contact" 
                class="modal-header-image" />
        </div>
        
        <!-- Formulaire de contact intégré via Contact Form 7 -->
        <div class="form-group">
            <!-- Utilisation du shortcode de Contact Form 7 pour afficher le formulaire -->
            <?php echo do_shortcode('[contact-form-7 id="4cac366" title="Formulaire de contact 1"]'); ?>
        </div>
        
    </div>
</div>
