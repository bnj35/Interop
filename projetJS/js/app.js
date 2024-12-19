'use strict';

import { addPopup } from './map.js';
import { getAir } from './Air.js';
import { getMeteo } from './meteo.js';
import { getCovid } from './covid.js';

addPopup();
getAir();
getMeteo();
getCovid();