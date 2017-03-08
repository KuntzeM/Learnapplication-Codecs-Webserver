/*************************************************************
 *
 *  MathJax/jax/output/CommonHTML/fonts/TeX/Main-Bold.js
 *
 *  Copyright (c) 2015-2016 The MathJax Consortium
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 */


(function (CHTML) {

    var font = 'MathJax_Main-Bold';

    MathJax.Hub.Insert(CHTML.FONTDATA.FONTS[font], {
        0xA0: [0, 0, 250, 0, 0],               // NO-BREAK SPACE
        0xA8: [695, -535, 575, 96, 478],       // DIAERESIS
        0xAC: [371, -61, 767, 64, 702],        // NOT SIGN
        0xAF: [607, -540, 575, 80, 494],       // MACRON
        0xB0: [702, -536, 575, 160, 414],      // DEGREE SIGN
        0xB1: [728, 35, 894, 64, 829],         // PLUS-MINUS SIGN
        0xB4: [706, -503, 575, 236, 460],      // ACUTE ACCENT
        0xD7: [530, 28, 894, 168, 726],        // MULTIPLICATION SIGN
        0xF7: [597, 96, 894, 64, 828],         // DIVISION SIGN
        0x131: [452, 8, 394, 24, 367],         // LATIN SMALL LETTER DOTLESS I
        0x237: [451, 201, 439, -12, 420],      // LATIN SMALL LETTER DOTLESS J
        0x2C6: [694, -520, 575, 126, 448],     // MODIFIER LETTER CIRCUMFLEX ACCENT
        0x2C7: [660, -515, 575, 130, 444],     // CARON
        0x2C9: [607, -540, 575, 80, 494],      // MODIFIER LETTER MACRON
        0x2CA: [706, -503, 575, 236, 460],     // MODIFIER LETTER ACUTE ACCENT
        0x2CB: [706, -503, 575, 114, 338],     // MODIFIER LETTER GRAVE ACCENT
        0x2D8: [694, -500, 575, 102, 472],     // BREVE
        0x2D9: [695, -525, 575, 202, 372],     // DOT ABOVE
        0x2DA: [702, -536, 575, 160, 414],     // RING ABOVE
        0x2DC: [694, -552, 575, 96, 478],      // SMALL TILDE
        0x300: [706, -503, 0, -461, -237],     // COMBINING GRAVE ACCENT
        0x301: [706, -503, 0, -339, -115],     // COMBINING ACUTE ACCENT
        0x302: [694, -520, 0, -449, -127],     // COMBINING CIRCUMFLEX ACCENT
        0x303: [694, -552, 0, -479, -97],      // COMBINING TILDE
        0x304: [607, -540, 0, -495, -81],      // COMBINING MACRON
        0x306: [694, -500, 0, -473, -103],     // COMBINING BREVE
        0x307: [695, -525, 0, -373, -203],     // COMBINING DOT ABOVE
        0x308: [695, -535, 0, -479, -97],      // COMBINING DIAERESIS
        0x30A: [702, -536, 0, -415, -161],     // COMBINING RING ABOVE
        0x30B: [714, -511, 0, -442, -82],      // COMBINING DOUBLE ACUTE ACCENT
        0x30C: [660, -515, 0, -445, -131],     // COMBINING CARON
        0x338: [711, 210, 0, -734, -161],      // COMBINING LONG SOLIDUS OVERLAY
        0x2002: [0, 0, 500, 0, 0],             // ??
        0x2003: [0, 0, 999, 0, 0],             // ??
        0x2004: [0, 0, 333, 0, 0],             // ??
        0x2005: [0, 0, 250, 0, 0],             // ??
        0x2006: [0, 0, 167, 0, 0],             // ??
        0x2009: [0, 0, 167, 0, 0],             // ??
        0x200A: [0, 0, 83, 0, 0],              // ??
        0x2013: [300, -249, 575, 0, 574],      // EN DASH
        0x2014: [300, -249, 1150, 0, 1149],    // EM DASH
        0x2018: [694, -329, 319, 58, 245],     // LEFT SINGLE QUOTATION MARK
        0x2019: [694, -329, 319, 74, 261],     // RIGHT SINGLE QUOTATION MARK
        0x201C: [694, -329, 603, 110, 564],    // LEFT DOUBLE QUOTATION MARK
        0x201D: [694, -329, 603, 38, 492],     // RIGHT DOUBLE QUOTATION MARK
        0x2020: [702, 211, 511, 64, 446],      // DAGGER
        0x2021: [702, 202, 511, 64, 446],      // DOUBLE DAGGER
        0x2026: [171, -1, 1295, 74, 1221],     // HORIZONTAL ELLIPSIS
        0x2032: [563, -33, 344, 35, 331],      // PRIME
        0x20D7: [723, -513, 0, -542, -33],     // COMBINING RIGHT ARROW ABOVE
        0x210F: [694, 8, 668, 45, 642],        // stix-/hbar - Planck's over 2pi
        0x2111: [702, 8, 831, 64, 798],        // BLACK-LETTER CAPITAL I
        0x2113: [702, 19, 474, -1, 446],       // SCRIPT SMALL L
        0x2118: [461, 210, 740, 72, 726],      // SCRIPT CAPITAL P
        0x211C: [711, 16, 831, 42, 824],       // BLACK-LETTER CAPITAL R
        0x2135: [694, 0, 703, 64, 638],        // ALEF SYMBOL
        0x2190: [518, 17, 1150, 64, 1084],     // LEFTWARDS ARROW
        0x2191: [694, 193, 575, 14, 561],      // UPWARDS ARROW
        0x2192: [518, 17, 1150, 65, 1085],     // RIGHTWARDS ARROW
        0x2193: [694, 194, 575, 14, 561],      // DOWNWARDS ARROW
        0x2194: [518, 17, 1150, 64, 1085],     // LEFT RIGHT ARROW
        0x2195: [767, 267, 575, 14, 561],      // UP DOWN ARROW
        0x2196: [724, 194, 1150, 64, 1084],    // NORTH WEST ARROW
        0x2197: [724, 193, 1150, 64, 1085],    // NORTH EAST ARROW
        0x2198: [694, 224, 1150, 65, 1085],    // SOUTH EAST ARROW
        0x2199: [694, 224, 1150, 64, 1085],    // SOUTH WEST ARROW
        0x21A6: [518, 17, 1150, 65, 1085],     // RIGHTWARDS ARROW FROM BAR
        0x21A9: [518, 17, 1282, 64, 1218],     // LEFTWARDS ARROW WITH HOOK
        0x21AA: [518, 17, 1282, 65, 1217],     // RIGHTWARDS ARROW WITH HOOK
        0x21BC: [518, -220, 1150, 64, 1084],   // LEFTWARDS HARPOON WITH BARB UPWARDS
        0x21BD: [281, 17, 1150, 64, 1084],     // LEFTWARDS HARPOON WITH BARB DOWNWARDS
        0x21C0: [518, -220, 1150, 65, 1085],   // RIGHTWARDS HARPOON WITH BARB UPWARDS
        0x21C1: [281, 17, 1150, 64, 1085],     // RIGHTWARDS HARPOON WITH BARB DOWNWARDS
        0x21CC: [718, 17, 1150, 64, 1085],     // RIGHTWARDS HARPOON OVER LEFTWARDS HARPOON
        0x21D0: [547, 46, 1150, 64, 1085],     // LEFTWARDS DOUBLE ARROW
        0x21D1: [694, 193, 703, 30, 672],      // UPWARDS DOUBLE ARROW
        0x21D2: [547, 46, 1150, 64, 1084],     // RIGHTWARDS DOUBLE ARROW
        0x21D3: [694, 194, 703, 30, 672],      // DOWNWARDS DOUBLE ARROW
        0x21D4: [547, 46, 1150, 47, 1102],     // LEFT RIGHT DOUBLE ARROW
        0x21D5: [767, 267, 703, 30, 672],      // UP DOWN DOUBLE ARROW
        0x2200: [694, 16, 639, 1, 640],        // FOR ALL
        0x2202: [710, 17, 628, 60, 657],       // PARTIAL DIFFERENTIAL
        0x2203: [694, -1, 639, 64, 574],       // THERE EXISTS
        0x2205: [767, 73, 575, 46, 528],       // EMPTY SET
        0x2207: [686, 24, 958, 56, 901],       // NABLA
        0x2208: [587, 86, 767, 97, 670],       // ELEMENT OF
        0x2209: [711, 210, 767, 97, 670],      // stix-negated (vert) set membership, variant
        0x220B: [587, 86, 767, 96, 670],       // CONTAINS AS MEMBER
        0x2212: [281, -221, 894, 96, 797],     // MINUS SIGN
        0x2213: [537, 227, 894, 64, 829],      // MINUS-OR-PLUS SIGN
        0x2215: [750, 250, 575, 63, 511],      // DIVISION SLASH
        0x2216: [750, 250, 575, 63, 511],      // SET MINUS
        0x2217: [472, -28, 575, 73, 501],      // ASTERISK OPERATOR
        0x2218: [474, -28, 575, 64, 510],      // RING OPERATOR
        0x2219: [474, -28, 575, 64, 510],      // BULLET OPERATOR
        0x221A: [820, 180, 958, 78, 988],      // SQUARE ROOT
        0x221D: [451, 8, 894, 65, 830],        // PROPORTIONAL TO
        0x221E: [452, 8, 1150, 65, 1084],      // INFINITY
        0x2220: [714, 0, 722, 55, 676],        // ANGLE
        0x2223: [750, 249, 319, 129, 190],     // DIVIDES
        0x2225: [750, 248, 575, 145, 430],     // PARALLEL TO
        0x2227: [604, 17, 767, 64, 702],       // LOGICAL AND
        0x2228: [604, 16, 767, 64, 702],       // LOGICAL OR
        0x2229: [603, 16, 767, 64, 702],       // stix-intersection, serifs
        0x222A: [604, 16, 767, 64, 702],       // stix-union, serifs
        0x222B: [711, 211, 569, 64, 632],      // INTEGRAL
        0x223C: [391, -109, 894, 64, 828],     // TILDE OPERATOR
        0x2240: [583, 82, 319, 64, 254],       // WREATH PRODUCT
        0x2243: [502, 3, 894, 64, 829],        // ASYMPTOTICALLY EQUAL TO
        0x2245: [638, 27, 1000, 64, 829],      // APPROXIMATELY EQUAL TO
        0x2248: [524, -32, 894, 64, 829],      // ALMOST EQUAL TO
        0x224D: [533, 32, 894, 64, 829],       // EQUIVALENT TO
        0x2250: [721, -109, 894, 64, 829],     // APPROACHES THE LIMIT
        0x2260: [711, 210, 894, 64, 829],      // stix-not (vert) equals
        0x2261: [505, 3, 894, 64, 829],        // IDENTICAL TO
        0x2264: [697, 199, 894, 96, 797],      // LESS-THAN OR EQUAL TO
        0x2265: [697, 199, 894, 96, 797],      // GREATER-THAN OR EQUAL TO
        0x226A: [617, 116, 1150, 64, 1085],    // MUCH LESS-THAN
        0x226B: [618, 116, 1150, 64, 1085],    // MUCH GREATER-THAN
        0x227A: [585, 86, 894, 96, 797],       // PRECEDES
        0x227B: [586, 86, 894, 96, 797],       // SUCCEEDS
        0x2282: [587, 85, 894, 96, 797],       // SUBSET OF
        0x2283: [587, 86, 894, 96, 796],       // SUPERSET OF
        0x2286: [697, 199, 894, 96, 797],      // SUBSET OF OR EQUAL TO
        0x2287: [697, 199, 894, 96, 796],      // SUPERSET OF OR EQUAL TO
        0x228E: [604, 16, 767, 64, 702],       // MULTISET UNION
        0x2291: [697, 199, 894, 96, 828],      // SQUARE IMAGE OF OR EQUAL TO
        0x2292: [697, 199, 894, 66, 797],      // SQUARE ORIGINAL OF OR EQUAL TO
        0x2293: [604, -1, 767, 70, 696],       // stix-square intersection, serifs
        0x2294: [604, -1, 767, 70, 696],       // stix-square union, serifs
        0x2295: [632, 132, 894, 64, 828],      // stix-circled plus (with rim)
        0x2296: [632, 132, 894, 64, 828],      // CIRCLED MINUS
        0x2297: [632, 132, 894, 64, 828],      // stix-circled times (with rim)
        0x2298: [632, 132, 894, 64, 828],      // CIRCLED DIVISION SLASH
        0x2299: [632, 132, 894, 64, 828],      // CIRCLED DOT OPERATOR
        0x22A2: [693, -1, 703, 65, 637],       // RIGHT TACK
        0x22A3: [693, -1, 703, 64, 638],       // LEFT TACK
        0x22A4: [694, -1, 894, 64, 829],       // DOWN TACK
        0x22A5: [693, -1, 894, 65, 829],       // UP TACK
        0x22A8: [750, 249, 974, 129, 918],     // TRUE
        0x22C4: [523, 21, 575, 15, 560],       // DIAMOND OPERATOR
        0x22C5: [336, -166, 319, 74, 245],     // DOT OPERATOR
        0x22C6: [502, 0, 575, 24, 550],        // STAR OPERATOR
        0x22C8: [540, 39, 1000, 33, 967],      // BOWTIE
        0x22EE: [951, 29, 319, 74, 245],       // VERTICAL ELLIPSIS
        0x22EF: [336, -166, 1295, 74, 1221],   // MIDLINE HORIZONTAL ELLIPSIS
        0x22F1: [871, -101, 1323, 129, 1194],  // DOWN RIGHT DIAGONAL ELLIPSIS
        0x2308: [750, 248, 511, 194, 493],     // LEFT CEILING
        0x2309: [750, 248, 511, 17, 317],      // RIGHT CEILING
        0x230A: [749, 248, 511, 194, 493],     // LEFT FLOOR
        0x230B: [749, 248, 511, 17, 317],      // RIGHT FLOOR
        0x2322: [405, -108, 1150, 65, 1084],   // stix-small down curve
        0x2323: [392, -126, 1150, 64, 1085],   // stix-small up curve
        0x25B3: [711, -1, 1022, 69, 953],      // WHITE UP-POINTING TRIANGLE
        0x25B9: [540, 39, 575, 33, 542],       // WHITE RIGHT-POINTING SMALL TRIANGLE
        0x25BD: [500, 210, 1022, 68, 953],     // WHITE DOWN-POINTING TRIANGLE
        0x25C3: [539, 38, 575, 33, 542],       // WHITE LEFT-POINTING SMALL TRIANGLE
        0x25EF: [711, 211, 1150, 65, 1084],    // LARGE CIRCLE
        0x2660: [719, 129, 894, 64, 829],      // BLACK SPADE SUIT
        0x2661: [711, 24, 894, 65, 828],       // WHITE HEART SUIT
        0x2662: [719, 154, 894, 64, 828],      // WHITE DIAMOND SUIT
        0x2663: [719, 129, 894, 32, 861],      // BLACK CLUB SUIT
        0x266D: [750, 17, 447, 64, 381],       // MUSIC FLAT SIGN
        0x266E: [741, 223, 447, 57, 389],      // MUSIC NATURAL SIGN
        0x266F: [724, 224, 447, 63, 382],      // MUSIC SHARP SIGN
        0x27E8: [750, 249, 447, 127, 382],     // MATHEMATICAL LEFT ANGLE BRACKET
        0x27E9: [750, 249, 447, 64, 319],      // MATHEMATICAL RIGHT ANGLE BRACKET
        0x27F5: [518, 17, 1805, 64, 1741],     // LONG LEFTWARDS ARROW
        0x27F6: [518, 17, 1833, 96, 1773],     // LONG RIGHTWARDS ARROW
        0x27F7: [518, 17, 2126, 64, 2061],     // LONG LEFT RIGHT ARROW
        0x27F8: [547, 46, 1868, 64, 1804],     // LONG LEFTWARDS DOUBLE ARROW
        0x27F9: [547, 46, 1870, 64, 1804],     // LONG RIGHTWARDS DOUBLE ARROW
        0x27FA: [547, 46, 2126, 64, 2060],     // LONG LEFT RIGHT DOUBLE ARROW
        0x27FC: [518, 17, 1833, 65, 1773],     // LONG RIGHTWARDS ARROW FROM BAR
        0x2A3F: [686, 0, 900, 39, 860],        // AMALGAMATION OR COPRODUCT
        0x2AAF: [696, 199, 894, 96, 797],      // PRECEDES ABOVE SINGLE-LINE EQUALS SIGN
        0x2AB0: [697, 199, 894, 96, 797]       // SUCCEEDS ABOVE SINGLE-LINE EQUALS SIGN
    });

    CHTML.fontLoaded("TeX/" + font.substr(8));

})(MathJax.OutputJax.CommonHTML);
