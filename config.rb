# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
http_path = "http://lawrencenaman.com/wp-content/themes/larry/css/"
images_dir = "i"
css_dir = "css"
sass_dir = "sass"
javascripts_dir = "js"

#Wordpress compiling http://css-tricks.com/compass-compiling-and-wordpress-themes/

require 'fileutils'
on_stylesheet_saved do |file|
  if File.exists?(file) && File.basename(file) == "style.css"
    puts "Moving: #{file}"
    FileUtils.mv(file, File.dirname(file) + "/../" + File.basename(file))
  end
end

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
