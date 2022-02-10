<div align="center">

![Magento 2 Preview/Visit Catalog](https://i.imgur.com/d8QEHRb.png)
# Magento 2 Preview/Visit Catalog

</div>

<div align="center">

[![Packagist Version](https://img.shields.io/github/v/tag/MagePsycho/magento2-preview-visit-catalog?logo=packagist&sort=semver&label=packagist&style=for-the-badge)](https://packagist.org/packages/magepsycho/magento2-gotocatalog)
[![Packagist Downloads](https://img.shields.io/packagist/dt/magepsycho/magento2-gotocatalog.svg?logo=composer&style=for-the-badge)](https://packagist.org/packages/magepsycho/magento2-gotocatalog/stats)
![Supported Magento Versions](https://img.shields.io/badge/magento-%202.3_|_2.4-brightgreen.svg?logo=magento&longCache=true&style=for-the-badge)
![License](https://img.shields.io/badge/license-MIT-green?color=%23234&style=for-the-badge)

</div>

## Overview
[Magento 2 Preview/Visit Catalog](https://www.magepsycho.com/magento2-preview-catalog-visit-sku.html) allows the store owner to quickly preview the catalog (product & category) pages from the admin panel.   
Also, it gives flexibility to the customers and the support & marketing team to visit the product page directly via SKU.

## Key Features
* Preview product page in the storefront (as per store) from Admin's product edit page
* Preview category page in the storefront (as per store) from Admin's category edit page
* Visit the product page directly via SKU in the URL (with the configurable prefix)


## Feature Highlights

### Quick Preview for Catalogs
With this extension, store admin can quickly explore the product & category pages via related edit pages, as per store.  
* Preview option can be turned off from settings
* Preview option is disabled if the product or category is not visible (disable or not visible individually)

![Magento 2 Preview/Visit Catalog - Admin Settings](https://www.magepsycho.com/media/catalog/product/3/_/3.m2-preview-visit-catalog-admin-category-preview.png)

![Magento 2 Preview/Visit Catalog - Product Page](https://www.magepsycho.com/media/catalog/product/6/_/6.m2-preview-visit-catalog-admin-product-preview.png)


### Visit Product Page via SKU

Users can reach the product page directly via SKU in the URL.  
* The prefix used in the URL can be configured from the extension settings.
* If SKU is not found or not visible, it will redirect to the search result page with SKU as the search-keyword.

![Magento 2 Preview/Visit Catalog - Admin Settings](https://www.magepsycho.com/media/catalog/product/2/_/2.m2-preview-visit-catalog-admin-catalog-settings.png)

![Magento 2 Preview/Visit Catalog - Product Page](https://www.magepsycho.com/media/catalog/product/9/_/9.m2-preview-visit-catalog-redirect-via-sku-url.png)

## 🛠️ Installation

**Using Composer**

```
composer require magepsycho/magento2-gotocatalog
```

**Using modman**
```
modman init
modman clone git@github.com:MagePsycho/magento2-preview-visit-catalog.git
```

**Using Zip**
* Download the [Zip File](https://github.com/MagePsycho/magento2-preview-visit-catalog/archive/master.zip)
* Extract & upload the files to `/path/to/magento2/app/code/MagePsycho/GoToCatalog/`

After installation by either means, activate the extension by running following series of commands
```
php bin/magento module:enable MagePsycho_GoToCatalog --clear-static-content
php bin/magento setup:upgrade
```
1. Flush the store cache
```
php bin/magento cache:flush
```
1. Deploy static content - *in Production mode only*
```
rm -rf pub/static/* var/view_preprocessed/*
php bin/magento setup:static-content:deploy
```
1. Go to Admin > STORES > Configuration > MAGEPSYCHO > Go To Catalog > Here you can configure settings

## Live Demo:

* [Frontend Demo](http://m2default.mage-expo.com)
* [Backend Demo](http://m2default.mage-expo.com/admin_m2demo/?module=gotocatalog)

## Changelog

**Version 1.0.0 (2021-03-15)**

* Initial Release.

## Authors
- Raj KB [![Twitter Follow](https://img.shields.io/twitter/follow/rajkbnp.svg?style=social)](https://twitter.com/rajkbnp)

## Contributors

![Your Repository's Stats](https://contrib.rocks/image?repo=MagePsycho/magento2-preview-visit-catalog)

## To Contribute
Any contribution to the development of `Magento 2 Preview/Visit Catalog` is highly welcome.  
The best possibility to provide any code is to open a [pull request on GitHub](https://github.com/MagePsycho/magento2-preview-visit-catalog/pulls).

## Need Support?
If you encounter any problems or bugs, please create an issue on [GitHub](https://github.com/MagePsycho/magento2-preview-visit-catalog/issues).

Please [visit our store](https://www.magepsycho.com/extensions/magento-2.html) for more FREE / paid extensions OR [contact us](https://magepsycho.com/contact) for customization / development services.

