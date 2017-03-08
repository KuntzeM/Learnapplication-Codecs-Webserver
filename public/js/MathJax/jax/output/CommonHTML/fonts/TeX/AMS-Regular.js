/*************************************************************
 *
 *  MathJax/jax/output/CommonHTML/fonts/TeX/AMS-Regular.js
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

    var font = 'MathJax_AMS';

    CHTML.FONTDATA.FONTS[font] = {
        className: CHTML.FONTDATA.familyName(font),
        centerline: 270, ascent: 1003, descent: 463,
        0x20: [0, 0, 250, 0, 0],               // SPACE
        0x41: [701, 1, 722, 17, 703],          // LATIN CAPITAL LETTER A
        0x42: [683, 1, 667, 11, 620],          // LATIN CAPITAL LETTER B
        0x43: [702, 19, 722, 39, 684],         // LATIN CAPITAL LETTER C
        0x44: [683, 1, 722, 16, 688],          // LATIN CAPITAL LETTER D
        0x45: [683, 1, 667, 12, 640],          // LATIN CAPITAL LETTER E
        0x46: [683, 1, 611, 12, 584],          // LATIN CAPITAL LETTER F
        0x47: [702, 19, 778, 39, 749],         // LATIN CAPITAL LETTER G
        0x48: [683, 1, 778, 14, 762],          // LATIN CAPITAL LETTER H
        0x49: [683, 1, 389, 20, 369],          // LATIN CAPITAL LETTER I
        0x4A: [683, 77, 500, 6, 478],          // LATIN CAPITAL LETTER J
        0x4B: [683, 1, 778, 22, 768],          // LATIN CAPITAL LETTER K
        0x4C: [683, 1, 667, 12, 640],          // LATIN CAPITAL LETTER L
        0x4D: [683, 1, 944, 17, 926],          // LATIN CAPITAL LETTER M
        0x4E: [683, 20, 722, 20, 702],         // LATIN CAPITAL LETTER N
        0x4F: [701, 19, 778, 34, 742],         // LATIN CAPITAL LETTER O
        0x50: [683, 1, 611, 16, 597],          // LATIN CAPITAL LETTER P
        0x51: [701, 181, 778, 34, 742],        // LATIN CAPITAL LETTER Q
        0x52: [683, 1, 722, 16, 705],          // LATIN CAPITAL LETTER R
        0x53: [702, 12, 556, 28, 528],         // LATIN CAPITAL LETTER S
        0x54: [683, 1, 667, 33, 635],          // LATIN CAPITAL LETTER T
        0x55: [683, 19, 722, 16, 709],         // LATIN CAPITAL LETTER U
        0x56: [683, 20, 722, 0, 719],          // LATIN CAPITAL LETTER V
        0x57: [683, 19, 1000, 5, 994],         // LATIN CAPITAL LETTER W
        0x58: [683, 1, 722, 16, 705],          // LATIN CAPITAL LETTER X
        0x59: [683, 1, 722, 16, 704],          // LATIN CAPITAL LETTER Y
        0x5A: [683, 1, 667, 29, 635],          // LATIN CAPITAL LETTER Z
        0x6B: [683, 1, 556, 17, 534],          // LATIN SMALL LETTER K
        0xA0: [0, 0, 250, 0, 0],               // NO-BREAK SPACE
        0xA5: [683, 0, 750, 11, 738],          // YEN SIGN
        0xAE: [709, 175, 947, 32, 915],        // REGISTERED SIGN
        0xF0: [749, 21, 556, 42, 509],         // LATIN SMALL LETTER ETH
        0x127: [695, 13, 540, 42, 562],        // LATIN SMALL LETTER H WITH STROKE
        0x2C6: [845, -561, 2333, -14, 2346],   // MODIFIER LETTER CIRCUMFLEX ACCENT
        0x2DC: [899, -628, 2333, 1, 2330],     // SMALL TILDE
        0x302: [845, -561, 0, -2347, 13],      // COMBINING CIRCUMFLEX ACCENT
        0x303: [899, -628, 0, -2332, -3],      // COMBINING TILDE
        0x3DD: [605, 85, 778, 55, 719],        // GREEK SMALL LETTER DIGAMMA
        0x3F0: [434, 6, 667, 37, 734],         // GREEK KAPPA SYMBOL
        0x2035: [560, -43, 275, 12, 244],      // REVERSED PRIME
        0x210F: [695, 13, 540, 42, 562],       // stix-/hbar - Planck's over 2pi
        0x2127: [684, 22, 722, 44, 675],       // INVERTED OHM SIGN
        0x2132: [695, 1, 556, 55, 497],        // TURNED CAPITAL F
        0x2136: [763, 21, 667, -22, 687],      // BET SYMBOL
        0x2137: [764, 43, 444, -22, 421],      // GIMEL SYMBOL
        0x2138: [764, 43, 667, 54, 640],       // DALET SYMBOL
        0x2141: [705, 23, 639, 37, 577],       // TURNED SANS-SERIF CAPITAL G
        0x2190: [437, -64, 500, 64, 422],      // LEFTWARDS ARROW
        0x2192: [437, -64, 500, 58, 417],      // RIGHTWARDS ARROW
        0x219A: [437, -60, 1000, 56, 942],     // LEFTWARDS ARROW WITH STROKE
        0x219B: [437, -60, 1000, 54, 942],     // RIGHTWARDS ARROW WITH STROKE
        0x219E: [417, -83, 1000, 56, 944],     // LEFTWARDS TWO HEADED ARROW
        0x21A0: [417, -83, 1000, 55, 943],     // RIGHTWARDS TWO HEADED ARROW
        0x21A2: [417, -83, 1111, 56, 1031],    // LEFTWARDS ARROW WITH TAIL
        0x21A3: [417, -83, 1111, 79, 1054],    // RIGHTWARDS ARROW WITH TAIL
        0x21AB: [575, 41, 1000, 56, 964],      // LEFTWARDS ARROW WITH LOOP
        0x21AC: [575, 41, 1000, 35, 943],      // RIGHTWARDS ARROW WITH LOOP
        0x21AD: [417, -83, 1389, 57, 1331],    // LEFT RIGHT WAVE ARROW
        0x21AE: [437, -60, 1000, 56, 942],     // LEFT RIGHT ARROW WITH STROKE
        0x21B0: [722, 0, 500, 56, 444],        // UPWARDS ARROW WITH TIP LEFTWARDS
        0x21B1: [722, 0, 500, 55, 443],        // UPWARDS ARROW WITH TIP RIGHTWARDS
        0x21B6: [461, 1, 1000, 17, 950],       // ANTICLOCKWISE TOP SEMICIRCLE ARROW
        0x21B7: [460, 1, 1000, 46, 982],       // CLOCKWISE TOP SEMICIRCLE ARROW
        0x21BA: [650, 83, 778, 56, 722],       // ANTICLOCKWISE OPEN CIRCLE ARROW
        0x21BB: [650, 83, 778, 56, 721],       // CLOCKWISE OPEN CIRCLE ARROW
        0x21BE: [694, 194, 417, 188, 375],     // UPWARDS HARPOON WITH BARB RIGHTWARDS
        0x21BF: [694, 194, 417, 41, 228],      // UPWARDS HARPOON WITH BARB LEFTWARDS
        0x21C2: [694, 194, 417, 188, 375],     // DOWNWARDS HARPOON WITH BARB RIGHTWARDS
        0x21C3: [694, 194, 417, 41, 228],      // DOWNWARDS HARPOON WITH BARB LEFTWARDS
        0x21C4: [667, 0, 1000, 55, 944],       // RIGHTWARDS ARROW OVER LEFTWARDS ARROW
        0x21C6: [667, 0, 1000, 55, 944],       // LEFTWARDS ARROW OVER RIGHTWARDS ARROW
        0x21C7: [583, 83, 1000, 55, 944],      // LEFTWARDS PAIRED ARROWS
        0x21C8: [694, 193, 833, 83, 749],      // UPWARDS PAIRED ARROWS
        0x21C9: [583, 83, 1000, 55, 944],      // RIGHTWARDS PAIRED ARROWS
        0x21CA: [694, 194, 833, 83, 749],      // DOWNWARDS PAIRED ARROWS
        0x21CB: [514, 14, 1000, 55, 944],      // LEFTWARDS HARPOON OVER RIGHTWARDS HARPOON
        0x21CC: [514, 14, 1000, 55, 944],      // RIGHTWARDS HARPOON OVER LEFTWARDS HARPOON
        0x21CD: [534, 35, 1000, 54, 942],      // LEFTWARDS DOUBLE ARROW WITH STROKE
        0x21CE: [534, 37, 1000, 32, 965],      // LEFT RIGHT DOUBLE ARROW WITH STROKE
        0x21CF: [534, 35, 1000, 55, 943],      // RIGHTWARDS DOUBLE ARROW WITH STROKE
        0x21DA: [611, 111, 1000, 76, 944],     // LEFTWARDS TRIPLE ARROW
        0x21DB: [611, 111, 1000, 55, 923],     // RIGHTWARDS TRIPLE ARROW
        0x21DD: [417, -83, 1000, 56, 943],     // RIGHTWARDS SQUIGGLE ARROW
        0x21E0: [437, -64, 1334, 64, 1251],    // LEFTWARDS DASHED ARROW
        0x21E2: [437, -64, 1334, 84, 1251],    // RIGHTWARDS DASHED ARROW
        0x2201: [846, 21, 500, 56, 444],       // COMPLEMENT
        0x2204: [860, 166, 556, 55, 497],      // THERE DOES NOT EXIST
        0x2205: [587, 3, 778, 54, 720],        // EMPTY SET
        0x220D: [440, 1, 429, 102, 456],       // SMALL CONTAINS AS MEMBER
        0x2212: [270, -230, 500, 84, 417],     // MINUS SIGN
        0x2214: [766, 93, 778, 57, 722],       // DOT PLUS
        0x2216: [430, 23, 778, 91, 685],       // SET MINUS
        0x221D: [472, -28, 778, 56, 722],      // PROPORTIONAL TO
        0x2220: [694, 0, 722, 55, 666],        // ANGLE
        0x2221: [714, 20, 722, 55, 666],       // MEASURED ANGLE
        0x2222: [551, 51, 722, 55, 666],       // SPHERICAL ANGLE
        0x2223: [430, 23, 222, 91, 131],       // DIVIDES
        0x2224: [750, 252, 278, -21, 297],     // DOES NOT DIVIDE
        0x2225: [431, 23, 389, 55, 331],       // PARALLEL TO
        0x2226: [750, 250, 500, -20, 518],     // NOT PARALLEL TO
        0x2234: [471, 82, 667, 24, 643],       // THEREFORE
        0x2235: [471, 82, 667, 23, 643],       // BECAUSE
        0x223C: [365, -132, 778, 55, 719],     // TILDE OPERATOR
        0x223D: [367, -133, 778, 56, 722],     // REVERSED TILDE
        0x2241: [467, -32, 778, 55, 719],      // stix-not, vert, similar
        0x2242: [463, -34, 778, 55, 720],      // MINUS TILDE
        0x2246: [652, 155, 778, 54, 720],      // APPROXIMATELY BUT NOT ACTUALLY EQUAL TO
        0x2248: [481, -50, 778, 55, 719],      // ALMOST EQUAL TO
        0x224A: [579, 39, 778, 51, 725],       // ALMOST EQUAL OR EQUAL TO
        0x224E: [492, -8, 778, 56, 722],       // GEOMETRICALLY EQUIVALENT TO
        0x224F: [492, -133, 778, 56, 722],     // DIFFERENCE BETWEEN
        0x2251: [609, 108, 778, 56, 722],      // GEOMETRICALLY EQUAL TO
        0x2252: [601, 101, 778, 15, 762],      // APPROXIMATELY EQUAL TO OR THE IMAGE OF
        0x2253: [601, 102, 778, 14, 762],      // IMAGE OF OR APPROXIMATELY EQUAL TO
        0x2256: [367, -133, 778, 56, 722],     // RING IN EQUAL TO
        0x2257: [721, -133, 778, 56, 722],     // RING EQUAL TO
        0x225C: [859, -133, 778, 56, 723],     // DELTA EQUAL TO
        0x2266: [753, 175, 778, 83, 694],      // LESS-THAN OVER EQUAL TO
        0x2267: [753, 175, 778, 83, 694],      // GREATER-THAN OVER EQUAL TO
        0x2268: [752, 286, 778, 82, 693],      // stix-less, vert, not double equals
        0x2269: [752, 286, 778, 82, 693],      // stix-gt, vert, not double equals
        0x226C: [750, 250, 500, 74, 425],      // BETWEEN
        0x226E: [708, 209, 778, 82, 693],      // stix-not, vert, less-than
        0x226F: [708, 209, 778, 82, 693],      // stix-not, vert, greater-than
        0x2270: [801, 303, 778, 82, 694],      // stix-not, vert, less-than-or-equal
        0x2271: [801, 303, 778, 82, 694],      // stix-not, vert, greater-than-or-equal
        0x2272: [732, 228, 778, 56, 722],      // stix-less-than or (contour) similar
        0x2273: [732, 228, 778, 56, 722],      // stix-greater-than or (contour) similar
        0x2276: [681, 253, 778, 44, 734],      // LESS-THAN OR GREATER-THAN
        0x2277: [681, 253, 778, 83, 694],      // GREATER-THAN OR LESS-THAN
        0x227C: [580, 153, 778, 83, 694],      // PRECEDES OR EQUAL TO
        0x227D: [580, 154, 778, 82, 694],      // SUCCEEDS OR EQUAL TO
        0x227E: [732, 228, 778, 56, 722],      // PRECEDES OR EQUIVALENT TO
        0x227F: [732, 228, 778, 56, 722],      // SUCCEEDS OR EQUIVALENT TO
        0x2280: [705, 208, 778, 82, 693],      // DOES NOT PRECEDE
        0x2281: [705, 208, 778, 82, 693],      // stix-not (vert) succeeds
        0x2288: [801, 303, 778, 83, 693],      // stix-/nsubseteq N: not (vert) subset, equals
        0x2289: [801, 303, 778, 82, 691],      // stix-/nsupseteq N: not (vert) superset, equals
        0x228A: [635, 241, 778, 84, 693],      // stix-subset, not equals, variant
        0x228B: [635, 241, 778, 82, 691],      // stix-superset, not equals, variant
        0x228F: [539, 41, 778, 83, 694],       // SQUARE IMAGE OF
        0x2290: [539, 41, 778, 64, 714],       // SQUARE ORIGINAL OF
        0x229A: [582, 82, 778, 57, 721],       // CIRCLED RING OPERATOR
        0x229B: [582, 82, 778, 57, 721],       // CIRCLED ASTERISK OPERATOR
        0x229D: [582, 82, 778, 57, 721],       // CIRCLED DASH
        0x229E: [689, 0, 778, 55, 722],        // SQUARED PLUS
        0x229F: [689, 0, 778, 55, 722],        // SQUARED MINUS
        0x22A0: [689, 0, 778, 55, 722],        // SQUARED TIMES
        0x22A1: [689, 0, 778, 55, 722],        // SQUARED DOT OPERATOR
        0x22A8: [694, 0, 611, 55, 555],        // TRUE
        0x22A9: [694, 0, 722, 55, 666],        // FORCES
        0x22AA: [694, 0, 889, 55, 833],        // TRIPLE VERTICAL BAR RIGHT TURNSTILE
        0x22AC: [695, 1, 611, -55, 554],       // DOES NOT PROVE
        0x22AD: [695, 1, 611, -55, 554],       // NOT TRUE
        0x22AE: [695, 1, 722, -55, 665],       // DOES NOT FORCE
        0x22AF: [695, 1, 722, -55, 665],       // NEGATED DOUBLE VERTICAL BAR DOUBLE RIGHT TURNSTILE
        0x22B2: [539, 41, 778, 83, 694],       // NORMAL SUBGROUP OF
        0x22B3: [539, 41, 778, 83, 694],       // CONTAINS AS NORMAL SUBGROUP
        0x22B4: [636, 138, 778, 83, 694],      // NORMAL SUBGROUP OF OR EQUAL TO
        0x22B5: [636, 138, 778, 83, 694],      // CONTAINS AS NORMAL SUBGROUP OR EQUAL TO
        0x22B8: [408, -92, 1111, 55, 1055],    // MULTIMAP
        0x22BA: [431, 212, 556, 57, 500],      // INTERCALATE
        0x22BB: [716, 0, 611, 55, 555],        // XOR
        0x22BC: [716, 0, 611, 55, 555],        // NAND
        0x22C5: [189, 0, 278, 55, 222],        // DOT OPERATOR
        0x22C7: [545, 44, 778, 55, 720],       // DIVISION TIMES
        0x22C9: [492, -8, 778, 146, 628],      // LEFT NORMAL FACTOR SEMIDIRECT PRODUCT
        0x22CA: [492, -8, 778, 146, 628],      // RIGHT NORMAL FACTOR SEMIDIRECT PRODUCT
        0x22CB: [694, 22, 778, 55, 722],       // LEFT SEMIDIRECT PRODUCT
        0x22CC: [694, 22, 778, 55, 722],       // RIGHT SEMIDIRECT PRODUCT
        0x22CD: [464, -36, 778, 56, 722],      // REVERSED TILDE EQUALS
        0x22CE: [578, 21, 760, 83, 676],       // CURLY LOGICAL OR
        0x22CF: [578, 22, 760, 83, 676],       // CURLY LOGICAL AND
        0x22D0: [540, 40, 778, 84, 694],       // DOUBLE SUBSET
        0x22D1: [540, 40, 778, 83, 693],       // DOUBLE SUPERSET
        0x22D2: [598, 22, 667, 55, 611],       // DOUBLE INTERSECTION
        0x22D3: [598, 22, 667, 55, 611],       // DOUBLE UNION
        0x22D4: [736, 22, 667, 56, 611],       // PITCHFORK
        0x22D6: [541, 41, 778, 82, 693],       // LESS-THAN WITH DOT
        0x22D7: [541, 41, 778, 82, 693],       // GREATER-THAN WITH DOT
        0x22D8: [568, 67, 1333, 56, 1277],     // VERY MUCH LESS-THAN
        0x22D9: [568, 67, 1333, 55, 1277],     // VERY MUCH GREATER-THAN
        0x22DA: [886, 386, 778, 83, 674],      // stix-less, equal, slanted, greater
        0x22DB: [886, 386, 778, 83, 674],      // stix-greater, equal, slanted, less
        0x22DE: [734, 0, 778, 83, 694],        // EQUAL TO OR PRECEDES
        0x22DF: [734, 0, 778, 82, 694],        // EQUAL TO OR SUCCEEDS
        0x22E0: [801, 303, 778, 82, 693],      // stix-not (vert) precedes or contour equals
        0x22E1: [801, 303, 778, 82, 694],      // stix-not (vert) succeeds or contour equals
        0x22E6: [730, 359, 778, 55, 719],      // LESS-THAN BUT NOT EQUIVALENT TO
        0x22E7: [730, 359, 778, 55, 719],      // GREATER-THAN BUT NOT EQUIVALENT TO
        0x22E8: [730, 359, 778, 55, 719],      // PRECEDES BUT NOT EQUIVALENT TO
        0x22E9: [730, 359, 778, 55, 719],      // SUCCEEDS BUT NOT EQUIVALENT TO
        0x22EA: [706, 208, 778, 82, 693],      // NOT NORMAL SUBGROUP OF
        0x22EB: [706, 208, 778, 82, 693],      // DOES NOT CONTAIN AS NORMAL SUBGROUP
        0x22EC: [802, 303, 778, 82, 693],      // stix-not, vert, left triangle, equals
        0x22ED: [801, 303, 778, 82, 693],      // stix-not, vert, right triangle, equals
        0x2322: [378, -122, 778, 55, 722],     // stix-small down curve
        0x2323: [378, -143, 778, 55, 722],     // stix-small up curve
        0x24C8: [709, 175, 902, 8, 894],       // CIRCLED LATIN CAPITAL LETTER S
        0x250C: [694, -306, 500, 55, 444],     // BOX DRAWINGS LIGHT DOWN AND RIGHT
        0x2510: [694, -306, 500, 55, 444],     // BOX DRAWINGS LIGHT DOWN AND LEFT
        0x2514: [366, 22, 500, 55, 444],       // BOX DRAWINGS LIGHT UP AND RIGHT
        0x2518: [366, 22, 500, 55, 444],       // BOX DRAWINGS LIGHT UP AND LEFT
        0x2571: [694, 195, 889, 0, 860],       // BOX DRAWINGS LIGHT DIAGONAL UPPER RIGHT TO LOWER LEFT
        0x2572: [694, 195, 889, 0, 860],       // BOX DRAWINGS LIGHT DIAGONAL UPPER LEFT TO LOWER RIGHT
        0x25A0: [689, 0, 778, 55, 722],        // BLACK SQUARE
        0x25A1: [689, 0, 778, 55, 722],        // WHITE SQUARE
        0x25B2: [575, 20, 722, 84, 637],       // BLACK UP-POINTING TRIANGLE
        0x25B3: [575, 20, 722, 84, 637],       // WHITE UP-POINTING TRIANGLE
        0x25B6: [539, 41, 778, 83, 694],       // BLACK RIGHT-POINTING TRIANGLE
        0x25BC: [576, 19, 722, 84, 637],       // BLACK DOWN-POINTING TRIANGLE
        0x25BD: [576, 19, 722, 84, 637],       // WHITE DOWN-POINTING TRIANGLE
        0x25C0: [539, 41, 778, 83, 694],       // BLACK LEFT-POINTING TRIANGLE
        0x25CA: [716, 132, 667, 56, 611],      // LOZENGE
        0x2605: [694, 111, 944, 49, 895],      // BLACK STAR
        0x2713: [706, 34, 833, 84, 749],       // CHECK MARK
        0x2720: [716, 22, 833, 48, 786],       // MALTESE CROSS
        0x29EB: [716, 132, 667, 56, 611],      // BLACK LOZENGE
        0x2A5E: [813, 97, 611, 55, 555],       // LOGICAL AND WITH DOUBLE OVERBAR
        0x2A7D: [636, 138, 778, 83, 694],      // LESS-THAN OR SLANTED EQUAL TO
        0x2A7E: [636, 138, 778, 83, 694],      // GREATER-THAN OR SLANTED EQUAL TO
        0x2A85: [762, 290, 778, 55, 722],      // LESS-THAN OR APPROXIMATE
        0x2A86: [762, 290, 778, 55, 722],      // GREATER-THAN OR APPROXIMATE
        0x2A87: [635, 241, 778, 82, 693],      // LESS-THAN AND SINGLE-LINE NOT EQUAL TO
        0x2A88: [635, 241, 778, 82, 693],      // GREATER-THAN AND SINGLE-LINE NOT EQUAL TO
        0x2A89: [761, 387, 778, 57, 718],      // LESS-THAN AND NOT APPROXIMATE
        0x2A8A: [761, 387, 778, 57, 718],      // GREATER-THAN AND NOT APPROXIMATE
        0x2A8B: [1003, 463, 778, 83, 694],     // LESS-THAN ABOVE DOUBLE-LINE EQUAL ABOVE GREATER-THAN
        0x2A8C: [1003, 463, 778, 83, 694],     // GREATER-THAN ABOVE DOUBLE-LINE EQUAL ABOVE LESS-THAN
        0x2A95: [636, 138, 778, 83, 694],      // SLANTED EQUAL TO OR LESS-THAN
        0x2A96: [636, 138, 778, 83, 694],      // SLANTED EQUAL TO OR GREATER-THAN
        0x2AB5: [752, 286, 778, 82, 693],      // PRECEDES ABOVE NOT EQUAL TO
        0x2AB6: [752, 286, 778, 82, 693],      // SUCCEEDS ABOVE NOT EQUAL TO
        0x2AB7: [761, 294, 778, 57, 717],      // PRECEDES ABOVE ALMOST EQUAL TO
        0x2AB8: [761, 294, 778, 57, 717],      // SUCCEEDS ABOVE ALMOST EQUAL TO
        0x2AB9: [761, 337, 778, 57, 718],      // PRECEDES ABOVE NOT ALMOST EQUAL TO
        0x2ABA: [761, 337, 778, 57, 718],      // SUCCEEDS ABOVE NOT ALMOST EQUAL TO
        0x2AC5: [753, 215, 778, 84, 694],      // SUBSET OF ABOVE EQUALS SIGN
        0x2AC6: [753, 215, 778, 83, 694],      // SUPERSET OF ABOVE EQUALS SIGN
        0x2ACB: [783, 385, 778, 82, 693],      // stix-subset not double equals, variant
        0x2ACC: [783, 385, 778, 82, 693],      // SUPERSET OF ABOVE NOT EQUAL TO
        0xE006: [430, 23, 222, -20, 240],      // ??
        0xE007: [431, 24, 389, -20, 407],      // ??
        0xE008: [605, 85, 778, 55, 719],       // ??
        0xE009: [434, 6, 667, 37, 734],        // ??
        0xE00C: [752, 284, 778, 82, 693],      // ??
        0xE00D: [752, 284, 778, 82, 693],      // ??
        0xE00E: [919, 421, 778, 82, 694],      // stix-not greater, double equals
        0xE00F: [801, 303, 778, 82, 694],      // stix-not greater-or-equal, slanted
        0xE010: [801, 303, 778, 82, 694],      // stix-not less-or-equal, slanted
        0xE011: [919, 421, 778, 82, 694],      // stix-not less, double equals
        0xE016: [828, 330, 778, 82, 694],      // stix-not subset, double equals
        0xE017: [752, 332, 778, 82, 694],      // ??
        0xE018: [828, 330, 778, 82, 694],      // stix-not superset, double equals
        0xE019: [752, 333, 778, 82, 693],      // ??
        0xE01A: [634, 255, 778, 84, 693],      // ??
        0xE01B: [634, 254, 778, 82, 691]       // ??
    };

    CHTML.fontLoaded("TeX/" + font.substr(8));

})(MathJax.OutputJax.CommonHTML);
