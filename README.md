<h1 align="center">Zanui_ApiWishlist</h1>

## Overview

API Wishlist is the extension which allowing customer after login to can get list items in their wishlist and they can add items to wishlist via API

## Installation

- Extract files from an archive
- In your Magento2 root directory, create this folder `app/code/Zanui/ApiWishlist`
- Copy all extracted files to the new folder
- Run this command to enable the extension `php bin/magento setup:upgrade`

## How To Use
### How to get customer token via rest API:
- API URL: {baseurl}/rest/V1/integration/customer/token
- Method: POST
- Authorization: Not required
- Body: 
```
{
    "username" : "",
    "password" : ""
}
```

### API Get wishlist items:
- API URL: `{baseurl}/rest/V1/wishlist/items`
- API URL with pagination: `{baseUrl}/rest/V1/wishlist/items?currentPage=1&pageSize=20`
- Method: GET
- Authorization: Customer Token
- Body: No
> **_NOTE:_**  default currentPage = 1 and pageSize = 20 .

### API Add wishlist items:
- API URL: `{baseurl}/rest/V1/wishlist/add`
- Method: POST
- Authorization: Customer Token
- Body: 
```
{
    "wishlist_items":{
        "wishlist_id": 1,
        "items": [
            {
                "sku": "MT10-XL-Yellow",
                "parent_sku":"MT10",
                "quantity": 1,
                "selected_options": [
                    "Y29uZmlndXJhYmxlLzE0Mi8xNzA=",
                    "Y29uZmlndXJhYmxlLzkzLzYw"
                ]
            },
            {
                "sku": "24-MB01",
                "quantity": 1,
            }
        ]
    }
}
```
> **_NOTE:_** The field selected_options is the **base64** encoded value for the child item of the configurable product which the user can select from the item.
> - Let with example:
>   + SKU MJ01 item with child item with Red Color and Size will be S.
>   + Here child item with Color attribute id is 93 and the Red Value option id is 67. So we can convert **_configurable/186/176_** to base64: Y29uZmlndXJhYmxlLzE4Ni8xNzY=

## License

[The Open Software License 3.0 (OSL-3.0)](https://opensource.org/licenses/OSL-3.0)
