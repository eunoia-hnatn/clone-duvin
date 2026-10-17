'use strict';

const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');
const script = fs.readFileSync(path.join(__dirname, '../public/assets/js/home.js'), 'utf8');

function element(attributes = {}) {
  const active = new Set();
  const listeners = {};
  return {
    attributes, listeners,
    classList: {add: name => active.add(name), remove: name => active.delete(name), contains: name => active.has(name)},
    addEventListener(type, handler) { listeners[type] = handler; },
    getAttribute(name) { return this.attributes[name] ?? null; },
    closest() { return null; }
  };
}

function run({slideCount = null, dotCount = 0, flickity = false, searchInput = false, anchors = [], observer = false} = {}) {
  const handlers = {};
  const windowHandlers = {};
  const timers = new Map();
  let timerId = 0;
  const slides = Array.from({length: slideCount ?? 0}, () => element());
  const dots = Array.from({length: dotCount}, () => element());
  const slider = slideCount === null ? null : element();
  if (slider) {
    if (flickity) slider.classList.add('flickity-enabled');
    slider.querySelectorAll = selector => selector === '.slide' ? slides : selector === '.dot' ? dots : [];
  }
  const search = searchInput ? element() : null;
  if (search) search.querySelector = () => null;
  let observed = 0;
  const context = {
    document: {
      body: null,
      addEventListener(type, fn) { (handlers[type] ??= []).push(fn); },
      querySelector(selector) { return selector === '.hero-slider' ? slider : selector === '.search-form' ? search : null; },
      querySelectorAll(selector) { return selector === 'a[href^="#"]' ? anchors : []; },
      getElementById() { return null; }
    },
    window: {
      addEventListener(type, fn) { windowHandlers[type] = fn; }
    },
    setInterval(fn) { timers.set(++timerId, fn); return timerId; },
    clearInterval(id) { timers.delete(id); },
    setTimeout() {},
    clearTimeout() {}
  };
  if (observer) context.window.IntersectionObserver = class { constructor() { observed++; } };
  vm.runInNewContext(script, context);
  for (const fn of handlers.DOMContentLoaded ?? []) fn();
  return {context, handlers, windowHandlers, timers, slider, slides, dots, search, observed};
}

let checks = 0;
function check(action) { action(); checks++; }

check(() => {
  const page = run();
  assert.equal(page.timers.size, 0);
  page.windowHandlers.load();
  assert.equal(page.context.isInViewport(null), false);
});
check(() => assert.equal(run({slideCount: 0}).timers.size, 0));
check(() => assert.equal(run({slideCount: 1}).timers.size, 0));
check(() => assert.equal(run({slideCount: 2, flickity: true}).timers.size, 0));
check(() => {
  const page = run({slideCount: 2});
  assert.equal(page.timers.size, 1);
  page.timers.values().next().value();
  assert.equal(page.slides[1].classList.contains('slide-active'), true);
});
check(() => {
  const page = run({slideCount: 2, dotCount: 1});
  page.timers.values().next().value();
  assert.equal(page.slides[1].classList.contains('slide-active'), true);
});
check(() => {
  const page = run({slideCount: 2, dotCount: 3});
  page.dots[2].listeners.click(); // Extra dots must not access a missing slide.
  assert.equal(page.timers.size, 1);
});
check(() => {
  const page = run({searchInput: true});
  page.search.listeners.submit.call(page.search, {});
});
check(() => {
  const anchor = element({href: '#a.b[1]'});
  run({anchors: [anchor]});
  anchor.listeners.click.call(anchor, {});
});
check(() => {
  const anchor = element({href: '#%E0%A4'});
  run({anchors: [anchor]});
  anchor.listeners.click.call(anchor, {});
});
check(() => {
  const page = run({observer: true});
  assert.equal(page.observed, 0); // No images: no observer work.
});
check(() => {
  const page = run({slideCount: 2});
  for (const callback of page.handlers.keydown) callback({key: 'ArrowRight', target: {closest: () => ({})}});
  assert.equal(page.slides.some(slide => slide.classList.contains('slide-active')), false);
});
console.log('PASS: ' + checks + ' home.js regression checks');
