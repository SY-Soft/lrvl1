import './bootstrap';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";

Fancybox.bind("[data-fancybox]", {});
