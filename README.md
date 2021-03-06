[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Medology/findalab/badges/quality-score.png?b=master&s=7722de14d64c14755fa8f122590a5400b7981a0f)](https://scrutinizer-ci.com/g/Medology/findalab/?branch=master)
[![CircleCI](https://circleci.com/gh/Medology/findalab.svg?style=svg)](https://circleci.com/gh/Medology/findalab)

# Find A Lab

The find a lab package is used throughout all of our (Healthlabs/Starfish) projects to implement our users to search
for a testing lab using their postal code and choosing a location best for them.

Installing Development Pre-Requisites
-------------------------------------

Install [Docker](https://www.docker.com).

[Configure your system path](https://github.com/Medology/Scripts/wiki/Project-executables-and-your-system-path).

The project uses private GitHub repositories. To allow the various tools (such as Composer, Yarn, etc) to use your
SSH keys to access these private repositories, we need to configure git to always use SSH instead of HTTPS. To do
so, ensure that the following is in your `~/.gitconfig` file:

```bash
git config --global url.git@github.com:.insteadOf git://github.com/
git config --global --add url.git@github.com:.insteadOf https://github.com/
```

## Install into Project
This plugin can be installed as a yarn package. Run the following command in the root of your project:

```bash
$ yarn add Medology/findalab
```

## Requirements

FindALabs only dependencies are an internal jQuery, and external google maps api.

## Setup

Include the following code to initialize the plugin on the page:

```js
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAP_API_KEY&amp;callback=initMap" async></script>
```

```js
import FindALab from "findalab";

window.initMap = function() {
  
}
FindALab('#findalab').load('/template/findalab.html', function() {
    FindALab(this).find('.findalab').findalab();
}
```
## Pre-loader

To include default pre-loader styles use the following markup (include class names and copy the images into the project folder).
everything inside the findalab-selector will be removed when the component is loaded.

```
<div id="findalab-selector">
  <div class="findalab-loading">
    <div class="findalab-loading__content">
      <h2>Loading Test Centers</h2>
      <img
        src="/three-dots.svg"
        alt="loading"
        width="50"
        onerror="this.src='/loading-gif.gif';this.onerror=null;" />
    </div>
  </div>
</div>
```

Make sure to override the height of `.findalab-loading` in each project's `settings.scss` file.
Design tip: It's best to be pixel perfect in this case and match the height of the loaded component for visual effect.

```scss
  //override the default height to match the component
  $mobile-loading-height: 461px;
  $findalab-loading: 729px;
```

## Custom Settings

The plugin can be customized by redefining `findalab` settings object.

```js
FindALab('#findalab-selector').load('../path/to/src/findalab.html', function() {
  const findalab = FindALab(this).find('.findalab').findalab({
    baseURL: YOUR_PROJECTS_URL,
    lab: {
      buttonText: 'Choose this place, yo!',
    },
    search: {
      buttonText: 'Find Now',
      placeholder: 'Fill in the zippaty',
    },
  });
});
```

## Use Current Location
If userLocation.showOption is set to true in the custom settings, clicking the button will find the location of the user
and search for the labs near the user's zipcode.

To view this in development, you will have to go to:
https://findalab.local/user-location.php

## Installing The Project For Development

To test and make updates to the jQuery plugin clone the repository:

```bash
$ git clone https://github.com/Medology/findalab.git && cd findalab/dev
```

Start the Docker Containers:

```bash
containers up
```

To setup your dev environment, you have to setup NPM and Bower dependencies. Run the following command in the root directory:

```bash
$ init_project
```

The preceding command will initialize the file `dev/.env`. Open the file and replace any placeholder environmental variables with the necessary API keys for testing.

Update your hosts file:

```bash
echo -e "\n\
127.0.0.1 findalab.local\n\
" | sudo tee -a /etc/hosts
```

You can visit the example site at [findalab.local](http://findalab.local/).

Finally, you can compile the stylesheets by running ```yarn dev``` in the root directory:

```bash
$ yarn dev
```

Yarn includes the `sass` task that compiles the example CSS as well as the `stylesheet` task that creates the individual CSS file.

## Releases

This project uses standard [semantic versioning](http://semver.org/). In order to publish a new version of the package, you have to do the following steps:

1. Write your changes in `CHANGELOG.md` (please follow the pattern of the document) with your PR.
2. Create a [new draft release](https://github.com/Medology/findalab/releases/new) using the merge commit from your PR and transfer the `CHANGELOG.md` information for this rlease in the appropriate version, title and description.
3. Publish the release and update your project(s) using the appropriate package manager.
