#!/bin/bash

# Frontpage
#rm src/Uni/AdminBundle/Entity/Frontpage.php
php app/console doctrine:generate:entities UniAdminBundle:Frontpage --path="src"
#rm src/Uni/AdminBundle/Form/FrontpageType.php
#rm src/Uni/AdminBundle/Controller/FrontpageController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:Frontpage --format=yml --with-write --overwrite --no-interaction --route-prefix='frontpage'

# Frontpage Photo
#rm src/Uni/AdminBundle/Entity/FrontpagePhoto.php
php app/console doctrine:generate:entities UniAdminBundle:FrontpagePhoto --path="src"
#rm src/Uni/AdminBundle/Form/FrontpagePhotoType.php
php app/console generate:doctrine:form UniAdminBundle:FrontpagePhoto

# Service
#rm src/Uni/AdminBundle/Entity/Service.php
php app/console doctrine:generate:entities UniAdminBundle:Service --path="src"
#rm src/Uni/AdminBundle/Form/ServiceType.php
#rm src/Uni/AdminBundle/Controller/ServiceController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:Service --format=yml --with-write --overwrite --no-interaction --route-prefix='service'

# Member
#rm src/Uni/AdminBundle/Entity/Member.php
php app/console doctrine:generate:entities UniAdminBundle:Member --path="src"
#rm src/Uni/AdminBundle/Form/MemberType.php
#rm src/Uni/AdminBundle/Controller/MemberController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:Member --format=yml --with-write --overwrite --no-interaction --route-prefix='member'

# Member Role
#rm src/Uni/AdminBundle/Entity/MemberRole.php
php app/console doctrine:generate:entities UniAdminBundle:MemberRole --path="src"
#rm src/Uni/AdminBundle/Form/MemberRoleType.php
#rm src/Uni/AdminBundle/Controller/MemberRoleController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:MemberRole --format=yml --with-write --overwrite --no-interaction --route-prefix='memberrole'

# Report
#rm src/Uni/AdminBundle/Entity/Report.php
php app/console doctrine:generate:entities UniAdminBundle:Report --path="src"
#rm src/Uni/AdminBundle/Form/ReportType.php
#rm src/Uni/AdminBundle/Controller/ReportController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:Report --format=yml --with-write --overwrite --no-interaction --route-prefix='report'

# History
#rm src/Uni/AdminBundle/Entity/History.php
php app/console doctrine:generate:entities UniAdminBundle:History --path="src"
#rm src/Uni/AdminBundle/Form/HistoryType.php
#rm src/Uni/AdminBundle/Controller/HistoryController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:History --format=yml --with-write --overwrite --no-interaction --route-prefix='history'

# Process
#rm src/Uni/AdminBundle/Entity/Process.php
php app/console doctrine:generate:entities UniAdminBundle:Process --path="src"
#rm src/Uni/AdminBundle/Form/ProcessType.php
#rm src/Uni/AdminBundle/Controller/ProcessController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:Process --format=yml --with-write --overwrite --no-interaction --route-prefix='process'

# Publication
#rm src/Uni/AdminBundle/Entity/Publication.php
php app/console doctrine:generate:entities UniAdminBundle:Publication --path="src"
#rm src/Uni/AdminBundle/Form/PublicationType.php
#rm src/Uni/AdminBundle/Controller/PublicationController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:Publication --format=yml --with-write --overwrite --no-interaction --route-prefix='publication'

# Notice
#rm src/Uni/AdminBundle/Entity/Notice.php
php app/console doctrine:generate:entities UniAdminBundle:Notice --path="src"
#rm src/Uni/AdminBundle/Form/NoticeType.php
#rm src/Uni/AdminBundle/Controller/NoticeController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:Notice --format=yml --with-write --overwrite --no-interaction --route-prefix='notice'

# Notice Category
#rm src/Uni/AdminBundle/Entity/NoticeCategory.php
php app/console doctrine:generate:entities UniAdminBundle:NoticeCategory --path="src"
#rm src/Uni/AdminBundle/Form/NoticeCategoryType.php
#rm src/Uni/AdminBundle/Controller/NoticeCategoryController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:NoticeCategory --format=yml --with-write --overwrite --no-interaction --route-prefix='noticecategory'

# Notice Photo
#rm src/Uni/AdminBundle/Entity/NoticePhoto.php
php app/console doctrine:generate:entities UniAdminBundle:NoticePhoto --path="src"
#rm src/Uni/AdminBundle/Form/NoticePhotoType.php
php app/console doctrine:generate:form UniAdminBundle:NoticePhoto

# Product
#rm src/Uni/AdminBundle/Entity/Product.php
php app/console doctrine:generate:entities UniAdminBundle:Product --path="src"
#rm src/Uni/AdminBundle/Form/ProductType.php
#rm src/Uni/AdminBundle/Controller/ProductController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:Product --format=yml --with-write --overwrite --no-interaction --route-prefix='product'

# Product Category
#rm src/Uni/AdminBundle/Entity/ProductCategory.php
php app/console doctrine:generate:entities UniAdminBundle:ProductCategory --path="src"
#rm src/Uni/AdminBundle/Form/ProductCategoryType.php
#rm src/Uni/AdminBundle/Controller/ProductCategoryController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:ProductCategory --format=yml --with-write --overwrite --no-interaction --route-prefix='productcategory'

# Product Photo
#rm src/Uni/AdminBundle/Entity/ProductPhoto.php
php app/console doctrine:generate:entities UniAdminBundle:ProductPhoto --path="src"
#rm src/Uni/AdminBundle/Form/ProductPhotoType.php
php app/console doctrine:generate:form UniAdminBundle:ProductPhoto

# Camera
#rm src/Uni/AdminBundle/Entity/Camera.php
php app/console doctrine:generate:entities UniAdminBundle:Camera --path="src"
#rm src/Uni/AdminBundle/Form/CameraType.php
#rm src/Uni/AdminBundle/Controller/CameraController.php
php app/console generate:doctrine:crud --entity=UniAdminBundle:Camera --format=yml --with-write --overwrite --no-interaction --route-prefix='camera'

# User
#rm src/Uni/UserBundle/Entity/User.php
php app/console doctrine:generate:entities UniUserBundle:User --path="src"
#rm src/Uni/UserBundle/Form/UserType.php
#rm src/Uni/UserBundle/Controller/UserController.php
php app/console generate:doctrine:crud --entity=UniUserBundle:User --format=yml --with-write --overwrite --no-interaction --route-prefix='user'

php app/console doctrine:schema:update --force
php app/console cache:clear --env=dev
php app/console cache:clear --env=prod
exit
