# Overridable Duration Rounding for Kimai2

Enables setting duration rounding option (same as global one) to override rounding for any Customer, Project or Activity.

| Plugin version | Supported Kimai version |
|----------------|-------------------------|
| 1.x            | 1.x                     |
| 2.x            | 2.x                     |

## Installation

Checkout plugin into `var/plugins/GlorpenDurationBundle` & clear cache.

Run `bin/console kimai:bundle:glorpen-duration:install`.

## Usage

After installation, existing Rounding methods will be extended with new functionality.
When editing any Customer, Project or Activity you can set *Rounding of the duration in minutes* option to override global one.
