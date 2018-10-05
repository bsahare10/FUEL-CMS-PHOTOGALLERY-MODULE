# FUEL-CMS-PHOTOGALLERY-MODULE
PHOTOGALLERY MODULE FOR FUEL CMS


This is my contribution back to FUEL-CMS, i have developed few modules for project and i like to share some of them. FUEL CMS GALLERY-MANAGER module for managing images(photos) related section. This is inbuild for same functionality as adding gallery-group and group-images also their corresponding functionality like(CRUD OPERATIONS) insert, update, and delete.

# INSTALLATION

  Installation is simple as other modules installation just with few new chnages and conf 

  1)    Download/clone the zip file from GitHub: https://github.com/bsahare10/FUEL-CMS-PHOTOGALLERY-MODULE

  2)    Create a "gallerymanager" folder in fuel/modules/ and place the contents of the extract-zip file there

  3)    Import the gallery_groups.sql & gallery_pics.sql from the gallerymanager/install folder into your database

  4)    Add "gallerymanager" to the $config['modules_allowed'] in fuel/application/config/MY_fuel.php

  5)    Create a "GalleryImages" folder in gallerymanager/assets/ and give rd permissions.
