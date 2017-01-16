function setVisibility(src) {
	var current = src;

  if (src == "#main") {
  	console.log("we are at main");
  	document.querySelector('#links-main').setAttribute('position','0 0 0');
  	document.querySelector('#links-main').setAttribute('visible',true);

  	document.querySelector('#links-kitchen').setAttribute('position','0 30 0');
  	document.querySelector('#links-kitchen').setAttribute('visible',false);

  	document.querySelector('#links-bedroom').setAttribute('position','0 30 0');
  	document.querySelector('#links-bedroom').setAttribute('visible',false);

  }
  else if (src == "#kitchen") {
  	console.log("we are at kitchen");
  	document.querySelector('#links-kitchen').setAttribute('position','0 0 0');
  	document.querySelector('#links-kitchen').setAttribute('visible',true);

  	document.querySelector('#links-main').setAttribute('position','0 30 0');
  	document.querySelector('#links-main').setAttribute('visible',false);

  	document.querySelector('#links-bedroom').setAttribute('position','0 30 0');
  	document.querySelector('#links-bedroom').setAttribute('visible',false);
  }
  else if (src == "#bedroom") {
  	console.log("we are at bedroom");
  	document.querySelector('#links-bedroom').setAttribute('position','0 0 0');
  	document.querySelector('#links-bedroom').setAttribute('visible',true);

  	document.querySelector('#links-kitchen').setAttribute('position','0 30 0');
  	document.querySelector('#links-kitchen').setAttribute('visible',false);

  	document.querySelector('#links-main').setAttribute('position','0 30 0');
  	document.querySelector('#links-main').setAttribute('visible',false);
  }
}

/* global AFRAME */

/**
 * Component that listens to an event, fades out an entity, swaps the texture, and fades it
 * back in.
 */
AFRAME.registerComponent('set-image', {
  schema: {
    on: {type: 'string'},
    target: {type: 'selector'},
    src: {type: 'string'},
    dur: {type: 'number', default: 300}
  },

  init: function () {
    var data = this.data;
    var el = this.el;

    this.setupFadeAnimation();
    setVisibility(data.src);

    el.addEventListener(data.on, function () {
      // Fade out image.
      data.target.emit('set-image-fade');
      // Wait for fade to complete.
      setTimeout(function () {
        // Set image.
        data.target.setAttribute('material', 'src', data.src);
      }, data.dur);

      setVisibility(data.src);
    });
  },

  /**
   * Setup fade-in + fade-out.
   */
  setupFadeAnimation: function () {
    var data = this.data;
    var targetEl = this.data.target;

    // Only set up once.
    if (targetEl.dataset.setImageFadeSetup) { return; }
    targetEl.dataset.setImageFadeSetup = true;

    // Create animation.
    targetEl.setAttribute('animation__fade', {
      property: 'material.color',
      startEvents: 'set-image-fade',
      dir: 'alternate',
      dur: data.dur,
      from: '#FFF',
      to: '#000'
    });
  }
});