# Laravel Recail

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rochmadnf/laravel-recail.svg)](https://packagist.org/packages/rochmadnf/laravel-recail)
[![Total Downloads](https://img.shields.io/packagist/dt/rochmadnf/laravel-recail.svg)](https://packagist.org/packages/rochmadnf/laravel-recail)

**Laravel Recail** stands for **Laravel React Email**. This package makes it easy to write email notification templates or components with [React Email](https://react.email) instead of using Blade or Markdown. If you are a **ReactJS Developer**, this package is perfect for you 😎.

## Installation

1. Change to your directory app.
   ```bash
   cd your-app-name
   ```
2. You can install the package via composer:

   ```bash
   composer require rochmadnf/laravel-recail
   ```

3. After that, install node dependencies:

   npm:

   ```bash
   npm i tsx react@18 @react-email/render @react-email/components
   ```

   ```bash
   npm i @types/node --save-dev
   ```

   yarn:

   ```bash
   yarn add tsx react@18 @react-email/render @react-email/components
   ```

   ```bash
   yarn add @types/node -D
   ```

   pnpm:

   ```bash
   pnpm add tsx react@18 @react-email/render @react-email/components
   ```

   ```bash
   pnpm add @types/node -D
   ```

## Usage

3. Preparing your mail directory.

   ```bash
   mkdir resources/views/mails
   ```

   > Note: You can customize the name and placement of email folders according to your preferences.

4. Config React Email in `.env` file.
   ```env
   REACT_EMAIL_DIRECTORY="/your/absolute/path/to/mail/directory/"
   REACT_EMAIL_NODE_PATH="/your/absolute/path/to/node/directory
   REACT_EMAIL_TSX_PATH="/your/basepath/to/tsx"
   ```
5. Create an email in the mail directory e.g `new-user.tsx` and make sure the component is `default export`.

   ```tsx
   import { Html, Text } from "@react-email/components";
   import * as React from "react";

   export default function NewUser({ user }) {
     return (
       <Html>
         <Text>
           Hello, <strong>{user.name}</strong> from Laravel Recail
         </Text>
       </Html>
     );
   }
   ```

6. Create laravel mailable via terminal.
   ```bash
   php artisan make:mail NewUser
   ```
7. Extend the mailable from ReactMailable instead of Mailable.

   ```php
   use App\Models\User;
   use Rochmadnf\Recail\ReactMailable;

   class NewUser extends ReactMailable
   {
      public function __construct(public User $user)
      {
         // public properties will be passed as props to the React email component
         // Alternatively use the with property of content
      }

      public function envelope()
      {
         return new Envelope(
               subject: 'New User',
         );
      }

      public function content()
      {
         return new Content(
               view: 'new-user', // name of the component file without extension
         );
      }
   }
   ```

8. Done. You can try your mail notifications 🎉

## Testing

```bash
./vendor/bin/pest
```

## Credits

- [Jamie Schouten](https://github.com/maantje)
- [All Contributors](https://github.com/maantje/laravel-react-email/graphs/contributors)
