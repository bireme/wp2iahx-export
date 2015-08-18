# WP2iAHx Export

## About
This plugin exports the WP content in a XML file compatible with the iAHx format.

## How to use
Activate the plugin and access `http://<domain>/?feed=iahx` to show the XML file.

You can also use the following parameters and filters:

* `count`- Display content limit (default: -1 = ALL)
* `offset`- Display offset number (default: 0)
* `cat_name`- Filter by category name (default: empty string)
* `order`- Sort from lowest to highest (ASC) or from highest to lowest (DESC). (default: DESC)
* `status`- Filter by post status (default: publish)
* `post_type`- Filter by post type (default: any)
* `type`- Type tag value
* `db`- DB (database) tag value
* `la`- LA (language) tag value
* `ct`- Apply the custom template in the output format

__NOTE:__ To use __ct__ parameter correctly:
* The __ct__ parameter value MUST BE equal to custom template file name
* The custom template file MUST BE a PHP file

## Usage example
```
http://<domain>/?feed=iahx&post_type=post&ct=custom_template&count=1
```
