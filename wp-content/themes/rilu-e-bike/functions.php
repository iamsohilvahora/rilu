<?php
/**
 * rilu-e-bike functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rilu-e-bike
 */

// List of postcode and address
$postcode = [
  0 => [
    'postcode' => '3000',
    'address' => 'Melbourne'
  ],
  1 => [
    'postcode' => '3002',
    'address' => 'East Melbourne'
  ],
  2 => [
    'postcode' => '3003',
    'address' => 'West Melbourne'
  ],
  3 => [
    'postcode' => '3004',
    'address' => 'Melbourne'
  ],
  4 => [
    'postcode' => '3004',
    'address' => 'St Kilda Road Central'
  ],
  5 => [
    'postcode' => '3005',
    'address' => 'World Trade Centre'
  ],
  6 => [
    'postcode' => '3006',
    'address' => 'South Wharf'
  ],
  7 => [
    'postcode' => '3006',
    'address' => 'Southbank'
  ],
  8 => [
    'postcode' => '3008',
    'address' => 'Docklands'
  ],
  9 => [
    'postcode' => '3010',
    'address' => 'University Of Melbourne'
  ],
  10 => [
    'postcode' => '3011',
    'address' => 'Footscray'
  ],
  11 => [
    'postcode' => '3011',
    'address' => 'Seddon'
  ],
  12 => [
    'postcode' => '3011',
    'address' => 'Seddon West'
  ],
  13 => [
    'postcode' => '3012',
    'address' => 'Brooklyn'
  ],
  14 => [
    'postcode' => '3012',
    'address' => 'Kingsville'
  ],
  15 => [
    'postcode' => '3012',
    'address' => 'Kingsville West'
  ],
  16 => [
    'postcode' => '3012',
    'address' => 'Maidstone'
  ],
  17 => [
    'postcode' => '3012',
    'address' => 'Tottenham'
  ],
  18 => [
    'postcode' => '3012',
    'address' => 'West Footscray'
  ],
  19 => [
    'postcode' => '3013',
    'address' => 'Yarraville'
  ],
  20 => [
    'postcode' => '3013',
    'address' => 'Yarraville West'
  ],
  21 => [
    'postcode' => '3015',
    'address' => 'Newport'
  ],
  22 => [
    'postcode' => '3015',
    'address' => 'South Kingsville'
  ],
  23 => [
    'postcode' => '3015',
    'address' => 'Spotswood'
  ],
  24 => [
    'postcode' => '3016',
    'address' => 'Williamstown'
  ],
  25 => [
    'postcode' => '3016',
    'address' => 'Williamstown North'
  ],
  26 => [
    'postcode' => '3018',
    'address' => 'Altona'
  ],
  27 => [
    'postcode' => '3018',
    'address' => 'Seaholme'
  ],
  28 => [
    'postcode' => '3019',
    'address' => 'Braybrook'
  ],
  29 => [
    'postcode' => '3019',
    'address' => 'Braybrook North'
  ],
  30 => [
    'postcode' => '3019',
    'address' => 'Robinson'
  ],
  31 => [
    'postcode' => '3020',
    'address' => 'Albion'
  ],
  32 => [
    'postcode' => '3020',
    'address' => 'Glengala'
  ],
  33 => [
    'postcode' => '3020',
    'address' => 'Sunshine'
  ],
  34 => [
    'postcode' => '3020',
    'address' => 'Sunshine North'
  ],
  35 => [
    'postcode' => '3020',
    'address' => 'Sunshine West'
  ],
  36 => [
    'postcode' => '3021',
    'address' => 'Albanvale'
  ],
  37 => [
    'postcode' => '3021',
    'address' => 'Kealba'
  ],
  38 => [
    'postcode' => '3021',
    'address' => 'Kings Park'
  ],
  39 => [
    'postcode' => '3021',
    'address' => 'St Albans'
  ],
  40 => [
    'postcode' => '3022',
    'address' => 'Ardeer'
  ],
  41 => [
    'postcode' => '3022',
    'address' => 'Deer Park East'
  ],
  42 => [
    'postcode' => '3023',
    'address' => 'Burnside'
  ],
  43 => [
    'postcode' => '3023',
    'address' => 'Burnside Heights'
  ],
  44 => [
    'postcode' => '3023',
    'address' => 'Cairnlea'
  ],
  45 => [
    'postcode' => '3023',
    'address' => 'Caroline Springs'
  ],
  46 => [
    'postcode' => '3023',
    'address' => 'Deer Park'
  ],
  47 => [
    'postcode' => '3023',
    'address' => 'Deer Park North'
  ],
  48 => [
    'postcode' => '3023',
    'address' => 'Ravenhall'
  ],
  49 => [
    'postcode' => '3024',
    'address' => 'Fieldstone'
  ],
  50 => [
    'postcode' => '3024',
    'address' => 'Manor Lakes'
  ],
  51 => [
    'postcode' => '3025',
    'address' => 'Altona East'
  ],
  52 => [
    'postcode' => '3025',
    'address' => 'Altona Gate'
  ],
  53 => [
    'postcode' => '3025',
    'address' => 'Altona North'
  ],
  54 => [
    'postcode' => '3026',
    'address' => 'Laverton North'
  ],
  55 => [
    'postcode' => '3027',
    'address' => 'Williams Landing'
  ],
  56 => [
    'postcode' => '3028',
    'address' => 'Altona Meadows'
  ],
  57 => [
    'postcode' => '3028',
    'address' => 'Laverton'
  ],
  58 => [
    'postcode' => '3028',
    'address' => 'Seabrook'
  ],
  59 => [
    'postcode' => '3029',
    'address' => 'Hoppers Crossing'
  ],
  60 => [
    'postcode' => '3029',
    'address' => 'Tarneit'
  ],
  61 => [
    'postcode' => '3029',
    'address' => 'Truganina'
  ],
  62 => [
    'postcode' => '3030',
    'address' => 'Chartwell'
  ],
  63 => [
    'postcode' => '3030',
    'address' => 'Cocoroc'
  ],
  64 => [
    'postcode' => '3030',
    'address' => 'Derrimut'
  ],
  65 => [
    'postcode' => '3030',
    'address' => 'Point Cook'
  ],
  66 => [
    'postcode' => '3030',
    'address' => 'Quandong'
  ],
  67 => [
    'postcode' => '3030',
    'address' => 'Werribee'
  ],
  68 => [
    'postcode' => '3030',
    'address' => 'Werribee South'
  ],
  69 => [
    'postcode' => '3031',
    'address' => 'Flemington'
  ],
  70 => [
    'postcode' => '3031',
    'address' => 'Kensington'
  ],
  71 => [
    'postcode' => '3032',
    'address' => 'Ascot Vale'
  ],
  72 => [
    'postcode' => '3032',
    'address' => 'Highpoint City'
  ],
  73 => [
    'postcode' => '3032',
    'address' => 'Maribyrnong'
  ],
  74 => [
    'postcode' => '3032',
    'address' => 'Travancore'
  ],
  75 => [
    'postcode' => '3033',
    'address' => 'Keilor East'
  ],
  76 => [
    'postcode' => '3034',
    'address' => 'Avondale Heights'
  ],
  77 => [
    'postcode' => '3036',
    'address' => 'Keilor'
  ],
  78 => [
    'postcode' => '3036',
    'address' => 'Keilor North'
  ],
  79 => [
    'postcode' => '3037',
    'address' => 'Calder Park'
  ],
  80 => [
    'postcode' => '3037',
    'address' => 'Delahey'
  ],
  81 => [
    'postcode' => '3037',
    'address' => 'Hillside'
  ],
  82 => [
    'postcode' => '3037',
    'address' => 'Plumpton'
  ],
  83 => [
    'postcode' => '3037',
    'address' => 'Sydenham'
  ],
  84 => [
    'postcode' => '3037',
    'address' => 'Taylors Hill'
  ],
  85 => [
    'postcode' => '3038',
    'address' => 'Keilor Downs'
  ],
  86 => [
    'postcode' => '3038',
    'address' => 'Keilor Lodge'
  ],
  87 => [
    'postcode' => '3038',
    'address' => 'Taylors Lakes'
  ],
  88 => [
    'postcode' => '3038',
    'address' => 'Watergardens'
  ],
  89 => [
    'postcode' => '3039',
    'address' => 'Moonee Ponds'
  ],
  90 => [
    'postcode' => '3040',
    'address' => 'Aberfeldie'
  ],
  91 => [
    'postcode' => '3040',
    'address' => 'Essendon'
  ],
  92 => [
    'postcode' => '3040',
    'address' => 'Essendon West'
  ],
  93 => [
    'postcode' => '3041',
    'address' => 'Essendon Fields'
  ],
  94 => [
    'postcode' => '3041',
    'address' => 'Essendon North'
  ],
  95 => [
    'postcode' => '3041',
    'address' => 'Strathmore'
  ],
  96 => [
    'postcode' => '3041',
    'address' => 'Strathmore Heights'
  ],
  97 => [
    'postcode' => '3042',
    'address' => 'Airport West'
  ],
  98 => [
    'postcode' => '3042',
    'address' => 'Keilor Park'
  ],
  99 => [
    'postcode' => '3042',
    'address' => 'Niddrie'
  ],
  100 => [
    'postcode' => '3043',
    'address' => 'Gladstone Park'
  ],
  101 => [
    'postcode' => '3043',
    'address' => 'Gowanbrae'
  ],
  102 => [
    'postcode' => '3043',
    'address' => 'Tullamarine'
  ],
  103 => [
    'postcode' => '3044',
    'address' => 'Pascoe Vale'
  ],
  104 => [
    'postcode' => '3044',
    'address' => 'Pascoe Vale South'
  ],
  105 => [
    'postcode' => '3045',
    'address' => 'Melbourne Airport'
  ],
  106 => [
    'postcode' => '3046',
    'address' => 'Glenroy'
  ],
  107 => [
    'postcode' => '3046',
    'address' => 'Hadfield'
  ],
  108 => [
    'postcode' => '3046',
    'address' => 'Oak Park'
  ],
  109 => [
    'postcode' => '3047',
    'address' => 'Broadmeadows'
  ],
  110 => [
    'postcode' => '3047',
    'address' => 'Dallas'
  ],
  111 => [
    'postcode' => '3047',
    'address' => 'Jacana'
  ],
  112 => [
    'postcode' => '3048',
    'address' => 'Coolaroo'
  ],
  113 => [
    'postcode' => '3048',
    'address' => 'Meadow Heights'
  ],
  114 => [
    'postcode' => '3049',
    'address' => 'Attwood'
  ],
  115 => [
    'postcode' => '3049',
    'address' => 'Westmeadows'
  ],
  116 => [
    'postcode' => '3050',
    'address' => 'Royal Melbourne Hospital'
  ],
  117 => [
    'postcode' => '3051',
    'address' => 'Hotham Hill'
  ],
  118 => [
    'postcode' => '3051',
    'address' => 'North Melbourne'
  ],
  119 => [
    'postcode' => '3052',
    'address' => 'Melbourne University'
  ],
  120 => [
    'postcode' => '3052',
    'address' => 'Parkville'
  ],
  121 => [
    'postcode' => '3053',
    'address' => 'Carlton'
  ],
  122 => [
    'postcode' => '3053',
    'address' => 'Carlton South'
  ],
  123 => [
    'postcode' => '3054',
    'address' => 'Carlton North'
  ],
  124 => [
    'postcode' => '3054',
    'address' => 'Princes Hill'
  ],
  125 => [
    'postcode' => '3055',
    'address' => 'Brunswick South'
  ],
  126 => [
    'postcode' => '3055',
    'address' => 'Brunswick West'
  ],
  127 => [
    'postcode' => '3055',
    'address' => 'Moonee Vale'
  ],
  128 => [
    'postcode' => '3055',
    'address' => 'Moreland West'
  ],
  129 => [
    'postcode' => '3056',
    'address' => 'Brunswick'
  ],
  130 => [
    'postcode' => '3056',
    'address' => 'Brunswick Lower'
  ],
  131 => [
    'postcode' => '3056',
    'address' => 'Brunswick North'
  ],
  132 => [
    'postcode' => '3057',
    'address' => 'Brunswick East'
  ],
  133 => [
    'postcode' => '3057',
    'address' => 'Lygon Street North'
  ],
  134 => [
    'postcode' => '3057',
    'address' => 'Sumner'
  ],
  135 => [
    'postcode' => '3058',
    'address' => 'Batman'
  ],
  136 => [
    'postcode' => '3058',
    'address' => 'Coburg'
  ],
  137 => [
    'postcode' => '3058',
    'address' => 'Coburg North'
  ],
  138 => [
    'postcode' => '3058',
    'address' => 'Merlynston'
  ],
  139 => [
    'postcode' => '3058',
    'address' => 'Moreland'
  ],
  140 => [
    'postcode' => '3059',
    'address' => 'Greenvale'
  ],
  141 => [
    'postcode' => '3060',
    'address' => 'Fawkner'
  ],
  142 => [
    'postcode' => '3060',
    'address' => 'Fawkner East'
  ],
  143 => [
    'postcode' => '3060',
    'address' => 'Fawkner North'
  ],
  144 => [
    'postcode' => '3061',
    'address' => 'Campbellfield'
  ],
  145 => [
    'postcode' => '3062',
    'address' => 'Somerton'
  ],
  146 => [
    'postcode' => '3063',
    'address' => 'Oaklands Junction'
  ],
  147 => [
    'postcode' => '3063',
    'address' => 'Yuroke'
  ],
  148 => [
    'postcode' => '3064',
    'address' => 'Craigieburn'
  ],
  149 => [
    'postcode' => '3064',
    'address' => 'Donnybrook'
  ],
  150 => [
    'postcode' => '3064',
    'address' => 'Kalkallo'
  ],
  151 => [
    'postcode' => '3064',
    'address' => 'Mickleham'
  ],
  152 => [
    'postcode' => '3064',
    'address' => 'Roxburgh Park'
  ],
  153 => [
    'postcode' => '3065',
    'address' => 'Fitzroy'
  ],
  154 => [
    'postcode' => '3066',
    'address' => 'Collingwood'
  ],
  155 => [
    'postcode' => '3066',
    'address' => 'Collingwood North'
  ],
  156 => [
    'postcode' => '3067',
    'address' => 'Abbotsford'
  ],
  157 => [
    'postcode' => '3068',
    'address' => 'Clifton Hill'
  ],
  158 => [
    'postcode' => '3068',
    'address' => 'Fitzroy North'
  ],
  159 => [
    'postcode' => '3070',
    'address' => 'Northcote'
  ],
  160 => [
    'postcode' => '3070',
    'address' => 'Northcote South'
  ],
  161 => [
    'postcode' => '3071',
    'address' => 'Thornbury'
  ],
  162 => [
    'postcode' => '3072',
    'address' => 'Gilberton'
  ],
  163 => [
    'postcode' => '3072',
    'address' => 'Northland Centre'
  ],
  164 => [
    'postcode' => '3072',
    'address' => 'Preston'
  ],
  165 => [
    'postcode' => '3072',
    'address' => 'Preston Lower'
  ],
  166 => [
    'postcode' => '3072',
    'address' => 'Preston South'
  ],
  167 => [
    'postcode' => '3072',
    'address' => 'Preston West'
  ],
  168 => [
    'postcode' => '3072',
    'address' => 'Regent West'
  ],
  169 => [
    'postcode' => '3072',
    'address' => 'Sylvester'
  ],
  170 => [
    'postcode' => '3073',
    'address' => 'Keon Park'
  ],
  171 => [
    'postcode' => '3073',
    'address' => 'Reservoir'
  ],
  172 => [
    'postcode' => '3073',
    'address' => 'Reservoir East'
  ],
  173 => [
    'postcode' => '3073',
    'address' => 'Reservoir North'
  ],
  174 => [
    'postcode' => '3073',
    'address' => 'Reservoir South'
  ],
  175 => [
    'postcode' => '3074',
    'address' => 'Thomastown'
  ],
  176 => [
    'postcode' => '3075',
    'address' => 'Lalor'
  ],
  177 => [
    'postcode' => '3075',
    'address' => 'Lalor Plaza'
  ],
  178 => [
    'postcode' => '3076',
    'address' => 'Epping'
  ],
  179 => [
    'postcode' => '3076',
    'address' => 'Epping Dc'
  ],
  180 => [
    'postcode' => '3078',
    'address' => 'Alphington'
  ],
  181 => [
    'postcode' => '3078',
    'address' => 'Fairfield'
  ],
  182 => [
    'postcode' => '3079',
    'address' => 'Ivanhoe'
  ],
  183 => [
    'postcode' => '3079',
    'address' => 'Ivanhoe East'
  ],
  184 => [
    'postcode' => '3079',
    'address' => 'Ivanhoe North'
  ],
  185 => [
    'postcode' => '3081',
    'address' => 'Bellfield'
  ],
  186 => [
    'postcode' => '3081',
    'address' => 'Heidelberg Heights'
  ],
  187 => [
    'postcode' => '3081',
    'address' => 'Heidelberg Rgh'
  ],
  188 => [
    'postcode' => '3081',
    'address' => 'Heidelberg West'
  ],
  189 => [
    'postcode' => '3082',
    'address' => 'Mill Park'
  ],
  190 => [
    'postcode' => '3083',
    'address' => 'Bundoora'
  ],
  191 => [
    'postcode' => '3083',
    'address' => 'Kingsbury'
  ],
  192 => [
    'postcode' => '3083',
    'address' => 'La Trobe University'
  ],
  193 => [
    'postcode' => '3084',
    'address' => 'Banyule'
  ],
  194 => [
    'postcode' => '3084',
    'address' => 'Eaglemont'
  ],
  195 => [
    'postcode' => '3084',
    'address' => 'Heidelberg'
  ],
  196 => [
    'postcode' => '3084',
    'address' => 'Rosanna'
  ],
  197 => [
    'postcode' => '3084',
    'address' => 'Viewbank'
  ],
  198 => [
    'postcode' => '3085',
    'address' => 'Macleod'
  ],
  199 => [
    'postcode' => '3085',
    'address' => 'Macleod West'
  ],
  200 => [
    'postcode' => '3085',
    'address' => 'Yallambie'
  ],
  201 => [
    'postcode' => '3086',
    'address' => 'La Trobe University'
  ],
  202 => [
    'postcode' => '3087',
    'address' => 'Watsonia'
  ],
  203 => [
    'postcode' => '3087',
    'address' => 'Watsonia North'
  ],
  204 => [
    'postcode' => '3088',
    'address' => 'Briar Hill'
  ],
  205 => [
    'postcode' => '3088',
    'address' => 'Greensborough'
  ],
  206 => [
    'postcode' => '3088',
    'address' => 'Saint Helena'
  ],
  207 => [
    'postcode' => '3088',
    'address' => 'St Helena'
  ],
  208 => [
    'postcode' => '3089',
    'address' => 'Diamond Creek'
  ],
  209 => [
    'postcode' => '3090',
    'address' => 'Plenty'
  ],
  210 => [
    'postcode' => '3091',
    'address' => 'Yarrambat'
  ],
  211 => [
    'postcode' => '3093',
    'address' => 'Lower Plenty'
  ],
  212 => [
    'postcode' => '3094',
    'address' => 'Montmorency'
  ],
  213 => [
    'postcode' => '3095',
    'address' => 'Eltham'
  ],
  214 => [
    'postcode' => '3095',
    'address' => 'Eltham North'
  ],
  215 => [
    'postcode' => '3095',
    'address' => 'Research'
  ],
  216 => [
    'postcode' => '3102',
    'address' => 'Kew East'
  ],
  217 => [
    'postcode' => '3105',
    'address' => 'Bulleen'
  ],
  218 => [
    'postcode' => '3105',
    'address' => 'Bulleen South'
  ],
  219 => [
    'postcode' => '3106',
    'address' => 'Templestowe'
  ],
  220 => [
    'postcode' => '3107',
    'address' => 'Templestowe Lower'
  ],
  221 => [
    'postcode' => '3108',
    'address' => 'Doncaster'
  ],
  222 => [
    'postcode' => '3109',
    'address' => 'Doncaster East'
  ],
  223 => [
    'postcode' => '3109',
    'address' => 'Doncaster Heights'
  ],
  224 => [
    'postcode' => '3109',
    'address' => 'The Pines'
  ],
  225 => [
    'postcode' => '3109',
    'address' => 'Tunstall Square Po'
  ],
  226 => [
    'postcode' => '3121',
    'address' => 'Burnley'
  ],
  227 => [
    'postcode' => '3121',
    'address' => 'Burnley North'
  ],
  228 => [
    'postcode' => '3121',
    'address' => 'Cremorne'
  ],
  229 => [
    'postcode' => '3121',
    'address' => 'Richmond'
  ],
  230 => [
    'postcode' => '3121',
    'address' => 'Richmond East'
  ],
  231 => [
    'postcode' => '3121',
    'address' => 'Richmond North'
  ],
  232 => [
    'postcode' => '3121',
    'address' => 'Richmond South'
  ],
  233 => [
    'postcode' => '3121',
    'address' => 'Victoria Gardens'
  ],
  234 => [
    'postcode' => '3141',
    'address' => 'Chapel Street North'
  ],
  235 => [
    'postcode' => '3141',
    'address' => 'Domain Road Po'
  ],
  236 => [
    'postcode' => '3141',
    'address' => 'South Yarra'
  ],
  237 => [
    'postcode' => '3182',
    'address' => 'St Kilda'
  ],
  238 => [
    'postcode' => '3182',
    'address' => 'St Kilda South'
  ],
  239 => [
    'postcode' => '3182',
    'address' => 'St Kilda West'
  ],
  240 => [
    'postcode' => '3184',
    'address' => 'Brighton Road'
  ],
  241 => [
    'postcode' => '3184',
    'address' => 'Elwood'
  ],
  242 => [
    'postcode' => '3205',
    'address' => 'South Melbourne'
  ],
  243 => [
    'postcode' => '3205',
    'address' => 'South Melbourne Dc'
  ],
  244 => [
    'postcode' => '3206',
    'address' => 'Albert Park'
  ],
  245 => [
    'postcode' => '3206',
    'address' => 'Middle Park'
  ],
  246 => [
    'postcode' => '3207',
    'address' => 'Garden City'
  ],
  247 => [
    'postcode' => '3207',
    'address' => 'Port Melbourne'
  ],
  248 => [
    'postcode' => '3335',
    'address' => 'Bonnie Brook'
  ],
  249 => [
    'postcode' => '3335',
    'address' => 'Grangefields'
  ],
  250 => [
    'postcode' => '3335',
    'address' => 'Plumpton'
  ],
  251 => [
    'postcode' => '3335',
    'address' => 'Rockbank'
  ],
  252 => [
    'postcode' => '3335',
    'address' => 'Thornhill Park'
  ],
  253 => [
    'postcode' => '3336',
    'address' => 'Aintree'
  ],
  254 => [
    'postcode' => '3336',
    'address' => 'Deanside'
  ],
  255 => [
    'postcode' => '3336',
    'address' => 'Fraser Rise'
  ],
  256 => [
    'postcode' => '3337',
    'address' => 'Harkness'
  ],
  257 => [
    'postcode' => '3337',
    'address' => 'Kurunjang'
  ],
  258 => [
    'postcode' => '3337',
    'address' => 'Melton'
  ],
  259 => [
    'postcode' => '3337',
    'address' => 'Melton West'
  ],
  260 => [
    'postcode' => '3337',
    'address' => 'Toolern Vale'
  ],
  261 => [
    'postcode' => '3338',
    'address' => 'Brookfield'
  ],
  262 => [
    'postcode' => '3338',
    'address' => 'Cobblebank'
  ],
  263 => [
    'postcode' => '3338',
    'address' => 'Exford'
  ],
  264 => [
    'postcode' => '3338',
    'address' => 'Eynesbury'
  ],
  265 => [
    'postcode' => '3338',
    'address' => 'Melton South'
  ],
  266 => [
    'postcode' => '3338',
    'address' => 'Strathtulloh'
  ],
  267 => [
    'postcode' => '3338',
    'address' => 'Weir Views'
  ],
  268 => [
    'postcode' => '3427',
    'address' => 'Diggers Rest'
  ],
  269 => [
    'postcode' => '3427',
    'address' => 'Plumpton'
  ],
  270 => [
    'postcode' => '3428',
    'address' => 'Bulla'
  ],
  271 => [
    'postcode' => '3429',
    'address' => 'Sunbury'
  ],
  272 => [
    'postcode' => '3429',
    'address' => 'Wildwood'
  ],
  273 => [
    'postcode' => '3750',
    'address' => 'Wollert'
  ],
  274 => [
    'postcode' => '3751',
    'address' => 'Woodstock'
  ],
  275 => [
    'postcode' => '3752',
    'address' => 'Morang South'
  ],
  276 => [
    'postcode' => '3752',
    'address' => 'South Morang'
  ],
  277 => [
    'postcode' => '3754',
    'address' => 'Doreen'
  ],
  278 => [
    'postcode' => '3754',
    'address' => 'Mernda'
  ]
];

define("postcode_lists", $postcode);

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rilu_e_bike_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on rilu-e-bike, use a find and replace
		* to change 'rilu-e-bike' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'rilu-e-bike', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Left Primary', 'rilu-e-bike' ),
			'menu-2' => esc_html__( 'Right Primary', 'rilu-e-bike' ),
			'menu-3' => esc_html__( 'Secondary', 'rilu-e-bike' ),
			'menu-4' => esc_html__( 'Dealer Menu', 'rilu-e-bike' ),
			'menu-5' => esc_html__( 'Mobile Menu', 'rilu-e-bike' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'rilu_e_bike_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'rilu_e_bike_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rilu_e_bike_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rilu_e_bike_content_width', 640 );
}
add_action('after_setup_theme', 'rilu_e_bike_content_width', 0);
/**
 * Enqueue scripts and styles.
 */
function rilu_e_bike_scripts(){
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wc-blocks-vendors-style');
	wp_dequeue_style('wc-blocks-style');
	
	if(!(is_single() || is_shop())){
		wp_dequeue_style('woocommerce-layout');
		wp_dequeue_style('woocommerce-smallscreen');
		wp_dequeue_style('woocommerce-general');

		wp_dequeue_script('wc-add-to-cart');
	}
	if(!is_single()){
		wp_dequeue_style('postcode-hit-listing'); // dequeue postcode hit listing css
		wp_dequeue_script('postcode-hit-listing'); // dequeue postcode hit listing css
		// dequeue wr360 css
		wp_dequeue_style('wr360-style');
		wp_dequeue_style('wr360-swiper-css');
		wp_dequeue_style('wr360-gallery-css');
		wp_dequeue_style('prettyphoto-css');
	}
	if(!(is_page_template('templates/customer_photos_reviews.php'))){
		wp_dequeue_script('njt_google_rv'); // dequeue google review js
	}
	if(!(is_front_page() || is_page_template('templates/customer_photos_reviews.php'))){
		wp_dequeue_style('njt_google_views');
		wp_dequeue_style('njt_google_slick');
	}
	if(!(is_page_template('templates/contact.php') || is_page_template('templates/new_dealer_registration.php'))){
		wp_dequeue_style('contact-form-7');
		wp_dequeue_script('contact-form-7');
	}
	// Load font-awesome js
	wp_enqueue_script('font-awesome', get_template_directory_uri() . '/js/fontawesome.js', array(), _S_VERSION, true);
	if(is_singular() && comments_open() && get_option('thread_comments')){
		wp_enqueue_script( 'comment-reply' );
	}
	// google map js
	wp_enqueue_script('map-script', "https://maps.googleapis.com/maps/api/js?key=AIzaSyDQREPH4gI-KbtFY40PfTU0s1J9PT51Lv0", array(), _S_VERSION, true);
	
	// load custom css file
	wp_enqueue_style('common-style', get_template_directory_uri().'/assets/css/common-style.min.css');
	wp_register_style('home-style', get_template_directory_uri().'/assets/css/home.min.css' , array(), '1.1', 'all');
	wp_register_style('product-style', get_template_directory_uri().'/assets/css/product-detail.min.css' , array(), '1.1', 'all');
	wp_register_style('product-category-style', get_template_directory_uri().'/assets/css/ebike-type.min.css' , array(), '1.1', 'all');
	wp_register_style('blog-style', get_template_directory_uri().'/assets/css/blog.min.css' , array(), '1.1', 'all');
    if(is_front_page()){
    	wp_enqueue_style('home-style');
    }
	if(is_product()){
		wp_enqueue_style('product-style');
		wp_dequeue_style('wr360-swiper-css');
		wp_dequeue_style('wr360-gallery-css');
  }
	if(is_product_category()){
		wp_enqueue_style('product-category-style');	
	}
	if(is_home() || is_single()){
		wp_enqueue_style('blog-style');
    }
	if(is_page_template('templates/about_us.php')){
        wp_enqueue_style('about-style', get_template_directory_uri().'/assets/css/about.min.css');
    }
	if(is_page_template('templates/dealer.php') || is_page_template('templates/state_dealer.php') || is_page_template('templates/new_dealer_registration.php') || is_singular('dealer')){
        wp_enqueue_style('dealer-style', get_template_directory_uri().'/assets/css/dealer.min.css');
    }
	if(is_page_template('templates/faq.php')){
		wp_enqueue_style('faq-style', get_template_directory_uri().'/assets/css/faq.min.css');
	}
	if(is_page_template('templates/customer_photos_reviews.php')){
		wp_enqueue_style('customer-photos-reviews-style', get_template_directory_uri().'/assets/css/customer-review.min.css');
	}
	if(is_page_template('templates/contact.php')){
		wp_enqueue_style('contact-style', get_template_directory_uri().'/assets/css/contact.min.css');
	}
	global $wp;
	$current_url = home_url(add_query_arg(array(), $wp->request)).'/';
	if($current_url == get_privacy_policy_url()){
		wp_enqueue_style('privacy-policy-style', get_template_directory_uri().'/assets/css/privacy-policy.min.css');
	}
	// Check host is localhost or not - load css and js
	if(WP_SERVER_NAME == 'localhost'){
		wp_enqueue_style('rilu-e-bike-style', get_stylesheet_uri(), array(), _S_VERSION);
		// Load Custom CSS and JS
		if(is_front_page() || is_product() || is_product_category() || is_page('about-us') || is_page('customer-photos-reviews')){
				wp_enqueue_style('slider', get_template_directory_uri() . '/assets/css/slick.css', array(), '1.1', 'all');
				wp_enqueue_script('slider', get_template_directory_uri() . '/assets/js/slick.min.js', array(), '1.1', 'all');
		}
		if(is_front_page() || is_page('customer-photos-reviews')){
			wp_enqueue_script( 'google-review-custom-script', get_template_directory_uri() . '/assets/js/google-review-custom.js', array(), '1.1', 'all');
		}
		// load custom js file
		wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.1.1', true);
		wp_enqueue_script('rilu-e-bike-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
		wp_enqueue_script('custom-theme-script', get_template_directory_uri() . '/assets/js/custom-script.js', array(), '1.1', 'all');
	}
	else{
		wp_enqueue_style('rilu-e-bike-style', get_template_directory_uri().'/style.min.css', array(), _S_VERSION);
		// Load Custom CSS and JS
		if(is_front_page() || is_product() || is_product_category() || is_page_template('templates/about_us.php') || is_page_template('templates/customer_photos_reviews.php')){
				wp_enqueue_style('slider', get_template_directory_uri() . '/assets/css/slick.min.css', array(), '1.1', 'all');
				wp_enqueue_script('slider', get_template_directory_uri() . '/assets/js/slick.min.js', array(), '1.1', 'all');
		}
		if(is_front_page() || is_page_template('templates/customer_photos_reviews.php')){
			wp_enqueue_script( 'google-review-custom-script', get_template_directory_uri() . '/assets/js/google-review-custom.min.js', array(), '1.1', 'all');
		}
		// load custom js file
		wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.min.js', array('jquery'), '1.1.1', true);
		wp_enqueue_script('rilu-e-bike-navigation', get_template_directory_uri() . '/js/navigation.min.js', array(), _S_VERSION, true );
		wp_enqueue_script('custom-theme-script', get_template_directory_uri() . '/assets/js/custom-script.min.js', array(), '1.1', 'all');
	}
	wp_style_add_data('rilu-e-bike-style', 'rtl', 'replace');
	// load AJAX variable
	wp_localize_script('custom-script', 'rilu_ajax_object',
	   array( 
	       'ajaxurl' => admin_url('admin-ajax.php'),
	       'siteurl' => get_site_url(),
	       'postcode_lists' => postcode_lists,
	   )
	);
}
add_action( 'wp_enqueue_scripts', 'rilu_e_bike_scripts');
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Load all widgets
 */
require get_template_directory() . '/inc/widgets.php';
/**
 * Load all shortcode
 */
require get_template_directory() . '/inc/shortcode.php';
/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Load all woocommerce hooks and function
 */
require get_template_directory() . '/inc/woocommerce.php';
/**
 * Load all common function
 */
require get_template_directory() . '/inc/common-functions.php';
/** 
 * Load custom post type 
 */
require get_template_directory().'/inc/custom_post_type.php';
// ALLOW SVG SUPPORT TO SERVER /
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
	$filetype = wp_check_filetype($filename, $mimes);
	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	];
}, 10, 4);
function byte_mime_types_callback( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'byte_mime_types_callback' );
// Button Group For Clone
function button_group($field_name){
    if(!empty($field_name) && is_array($field_name)){
		$button_link = '';
		$button_link_type = $field_name['button_link'];
		$internal_link = $field_name['button_internal_link'];
		$external_link = $field_name['button_external_link'];
		if(($button_link_type == 'button_internal_link') && !empty($internal_link)){
			$button_link = rilu_external_link($internal_link, false);
		} 
		elseif(($button_link_type == 'button_external_link') && !empty($external_link)){
			$button_link = rilu_external_link($external_link, true);
		}
		if(!empty($button_link)){
			return $button_link;
		} 
		else{
			return '';
		}
    } 
    else{
    	return;
    }
}
function rilu_external_link($link = null, $target = null){
    if(empty($link)){
        return;
    }
    $href_link = null;
    if(!empty($link) && $link != null){
        if($link == '#' ){
            $href_link = $link;
            $target = '';
        } 
        else{
            $url =  trim($link);
            if(!preg_match("~^(?:f|ht)tps?://~i", $url)){
                $href_link= "http://" . $url;
            }
            else{
                $href_link = trim($link);
            }
        }
    }
    if ($target == true){
        return 'href="'.$href_link.'" target="_blank"';
    }
    else{
        return 'href="'.$href_link.'"';
    }
}
function wp_deregister_my_css_js(){
	if(!is_single() || is_product() ){
		// dequeue wr360 js
        if(is_product()){
    		wp_dequeue_script('wr360-swiper-js');
    		wp_dequeue_script('wr360-gallery-js');
        }
        else{
            wp_dequeue_script('wr360-wp-script');
            wp_deregister_script('wr360-script');
            wp_dequeue_script('wr360-swiper-js');
    		wp_dequeue_script('wr360-gallery-js');
        }
	}
	if(!(is_single() || is_shop())){
		wp_dequeue_script('js-cookie'); 
		wp_dequeue_script('jquery-blockui'); 
		wp_dequeue_script('wc-cart-fragments'); 
		wp_dequeue_script('woocommerce'); 
	}
}
add_action('wp_footer', 'wp_deregister_my_css_js');
add_filter( 'wpcf7_validate_configuration', '__return_false' );