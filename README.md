# Overridable Duration Rounding for Kimai2

Enables setting duration rounding option (same as global one) to override rounding for any Customer, Project or Activity.

## Installation

Checkout plugin into `var/plugins/GlorpenDurationBundle` & clear cache.

## Usage

To activate overridable durations, you have to choose one of new global Rounding methods:

- Ceil, but with overridable duration rounding
- Closest, but with overridable duration rounding
- Standard, but with overridable duration rounding
- Floor, but with overridable duration rounding

after that, when editing any Customer, Project or Activity you can set *Rounding of the duration in minutes* option to override global one.
