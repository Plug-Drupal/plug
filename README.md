[![Build Status](https://travis-ci.org/Plug-Drupal/plug.svg?branch=7.x-1.x)](https://travis-ci.org/Plug-Drupal/plug) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mateu-aguilo-bosch/plug/badges/quality-score.png?b=7.x-1.x)](https://scrutinizer-ci.com/g/mateu-aguilo-bosch/plug/?branch=7.x-1.x) [![Join the chat at https://gitter.im/Plug-Drupal/plug](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/Plug-Drupal/plug?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
# Plug

Get the **plugin system** for Drupal 8 in your **Drupal 7 developments**.

The Plug module is a module for developers that can't wait until Drupal 8 comes out to use the plugin system that will ship with it. You can use this as an alternative to your custom CTools plugins.

## Do I need this module?
This is one of those modules that does nothing by itself, but provides tools for developers for a better developer experience. If you write custom PHP code for Drupal in a day to day basis, you can probably take advantage of this module and start writing plugins.

In Drupal 8 _everything_ is a plugin, by starting to write Drupal 8 style plugins today you accomplish two main objectives:

  - Your code is more capable to cope with change, is more maintainable and flexible.
  - You are already learning how you will program for Drupal 8 [when it comes out](http://drupalreleasedate.com/).

## Examples
Here you have a couple of examples. The best thing that you can do is read this [amazing post about plugins](https://drupalize.me/blog/201407/drupal-8-plugins-explained).

## Architecture
This module relies on some parts of the Drupal 8 code. Those parts have been encapsulated inside this module to simplify the installation process.

### Implementation examples
There is an [example module](modules/plug_example/plug_example.module) shipped with this module that will show you how to create your plugins and use them.

### Things that can be plugins.
Beep-boop-clink-clank, this section is not done just yet. Check back soon!

> Situations in which plugins are useful? Anytime you need to allow modules to provide additional "things" that implement the same interface but provide distinctly different functionality. Blocks are the classic example. In Drupal every block consists of essentially the same parts, a label, some content, and various settings related to visibility and cachability. How that label and content is generated is likely very different from one module to the next though. A custom block with static content vs. one provided by Views for example.

## Installing
Installation is straightforward. You only need to download and enable the module.

## Implementations
The following modules use the <strong>Plug</strong> module to declare their plugins. If you want your module to be in this list, [open an issue](https://github.com/mateu-aguilo-bosch/plug/issues/new).

  - [Plug Field](https://github.com/Plug-Drupal/plug_field)
  - [Plug Config](https://github.com/Plug-Drupal/plug_config)
