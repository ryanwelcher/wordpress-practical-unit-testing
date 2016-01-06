#WordPress Unit Testing with WP_MOCK #



##Installation##
Clone this repo locally: `git clone https://github.com/ryanwelcher/unit-test-wp-mock.git`

Navigation to the directory: `cd unit-test-wp-mock`

Run `composer install` to install phpunit and WP_Mock


##Vagrant##

If you're using VVV or another Vagrant based virtual machine, you can add the following line to your CustomFile or VagrantFile
to load the plugin into WordPress - just update the paths as needed.

`config.vm.synced_folder "~/repositories/unit-test-examples", "/srv/www/wordpress-develop/src/wp-content/plugins/unit-test-example", owner: 'www-data', group: 'www-data', mount_options: ["dmode=775", "fmode=664"]`


