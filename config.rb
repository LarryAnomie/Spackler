# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
#http_path = "http://lawrencenaman.com/wp-content/themes/larry/css/"
#http_path = "/"
images_dir = "assets/i"
css_dir = "/"
sass_dir = "assets/sass"
javascripts_dir = "assets/js"
fonts_dir = "assets/fonts"
relative_assets = true

#Wordpress compiling http://css-tricks.com/compass-compiling-and-wordpress-themes/


#lets enable the sass debug info
#sass_options = {:debug_info => true, :quiet => true}
output_style = (environment == :production) ? :compressed : :expanded

#options for output_style: ":nested", ":expanded", ":compact", ":compressed"
output_style = :compressed

#kill the built in cache buster
asset_cache_buster :none

#require "zurb-foundation"

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed

# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false


# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass
