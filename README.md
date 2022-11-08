# The Fresh Bang (SFN boilerplate)
The Universe started with The Big Bang. So every SFN project should start with The Fresh Bang.

## How to install
1. Create new project with composer:
   ```console
   composer create-project -s dev studiofreshnet/freshbang ./ --repository='{"type": "vcs","url": "https://gitlab.com/studiofreshnet/freshbang.git"}'
   ```
1. Update namespace in `composer.json` for PSR-4 autoload:
   ```json
   {
       "autoload": {
            "psr-4": {
                "YourProjectNamespace\\": "app/"
            }
        }
   }
   ``` 
1. Install PHP & Node.js packages and build assets:
   ```console
   composer install
   npm install
   gulp default
   ```
1. That's it.
