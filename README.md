# 5pluskids

5pluskids.uz website source

Project built with [Yii 2.0 Framework](https://www.yiiframework.com/), based on [Yii2 advanced Application Template](https://github.com/yiisoft/yii2-app-advanced).

Composer, Yarn and Grunt used.

SQL file in root directory instead of migrations, someday I'll made migrations... maybe.

#### Config:
1. DB credentials are mandatory
2. Google ReCaptcha - credentials in config are mandatory.
3. Tinypng.com - fill tinifyKey to lossless compress uploaded images.
4. To enable SQL-backups upload to Google.Drive *add google_auth_data* and *backupFolderName* into console params-local

#### Console commands:
- `yii mail/send` to send emails from queue
- `yii backup/create` to create SQL-backup
- `yii tinify/tinify` to run lossless compress on images uploaded by WYSIWYG-editor