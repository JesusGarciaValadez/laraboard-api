<?php

namespace App\Models;

use Database\Factories\CountryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class Country
 *
 * @package App\Models
 * @property string $name
 * @property string|null $description
 * @property string|null $code
 * @property string|null $iso
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static CountryFactory factory(...$parameters)
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCode($value)
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereDescription($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereIso($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Country extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'code',
        'iso',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id'];

    private static array $countries = [
        [
            'name' => 'Afghanistan',
            'description' => 'AFGHANISTAN',
            'code' => '93',
            'iso' => 'AF / AFG',
        ],
        [
            'name' => 'Albania',
            'description' => 'ALBANIA',
            'code' => '355',
            'iso' => 'AL / ALB',
        ],
        [
            'name' => 'Algeria',
            'description' => 'ALGERIA',
            'code' => '213',
            'iso' => 'DZ / DZA',
        ],
        [
            'name' => 'American Samoa',
            'description' => 'AMERICAN SAMOA',
            'code' => '1-684',
            'iso' => 'AS / ASM',
        ],
        [
            'name' => 'Andorra',
            'description' => 'ANDORRA',
            'code' => '376',
            'iso' => 'AD / AND',
        ],
        [
            'name' => 'Angola',
            'description' => 'ANGOLA',
            'code' => '244',
            'iso' => 'AO / AGO',
        ],
        [
            'name' => 'Anguilla',
            'description' => 'ANGUILLA',
            'code' => '1-264',
            'iso' => 'AI / AIA',
        ],
        [
            'name' => 'Antarctica',
            'description' => 'ANTARCTICA',
            'code' => '672',
            'iso' => 'AQ / ATA',
        ],
        [
            'name' => 'Antigua and Barbuda',
            'description' => 'ANTIGUA AND BARBUDA',
            'code' => '1-268',
            'iso' => 'AG / ATG',
        ],
        [
            'name' => 'Argentina',
            'description' => 'ARGENTINA',
            'code' => '54',
            'iso' => 'AR / ARG',
        ],
        [
            'name' => 'Armenia',
            'description' => 'ARMENIA',
            'code' => '374',
            'iso' => 'AM / ARM',
        ],
        [
            'name' => 'Aruba',
            'description' => 'ARUBA',
            'code' => '297',
            'iso' => 'AW / ABW',
        ],
        [
            'name' => 'Australia',
            'description' => 'AUSTRALIA',
            'code' => '61',
            'iso' => 'AU / AUS',
        ],
        [
            'name' => 'Austria',
            'description' => 'AUSTRIA',
            'code' => '43',
            'iso' => 'AT / AUT',
        ],
        [
            'name' => 'Azerbaijan',
            'description' => 'AZERBAIJAN',
            'code' => '994',
            'iso' => 'AZ / AZE',
        ],
        [
            'name' => 'Bahamas',
            'description' => 'BAHAMAS',
            'code' => '1-242',
            'iso' => 'BS / BHS',
        ],
        [
            'name' => 'Bahrain',
            'description' => 'BAHRAIN',
            'code' => '973',
            'iso' => 'BH / BHR',
        ],
        [
            'name' => 'Bangladesh',
            'description' => 'BANGLADESH',
            'code' => '880',
            'iso' => 'BD / BGD',
        ],
        [
            'name' => 'Barbados',
            'description' => 'BARBADOS',
            'code' => '1-246',
            'iso' => 'BB / BRB',
        ],
        [
            'name' => 'Belarus',
            'description' => 'BELARUS',
            'code' => '375',
            'iso' => 'BY / BLR',
        ],
        [
            'name' => 'Belgium',
            'description' => 'BELGIUM',
            'code' => '32',
            'iso' => 'BE / BEL',
        ],
        [
            'name' => 'Belize',
            'description' => 'BELIZE',
            'code' => '501',
            'iso' => 'BZ / BLZ',
        ],
        [
            'name' => 'Benin',
            'description' => 'BENIN',
            'code' => '229',
            'iso' => 'BJ / BEN',
        ],
        [
            'name' => 'BERMUDA',
            'description' => 'Bermuda',
            'code' => '1-441',
            'iso' => 'BM / BMU',
        ],
        [
            'name' => 'Bhutan',
            'description' => 'BHUTAN',
            'code' => '975',
            'iso' => 'BT / BTN',
        ],
        [
            'name' => 'Bolivia',
            'description' => 'BOLIVIA (PLURINATIONAL STATE OF)',
            'code' => '591',
            'iso' => 'BO / BOL',
        ],
        [
            'name' => 'Bonaire, sint Eustatius and Saba',
            'description' => 'BONAIRE, SINT EUSTATIUS AND SABA',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Bosnia and Herzegovina',
            'description' => 'BOSNIA AND HERZEGOVINA',
            'code' => '387',
            'iso' => 'BA / BIH',
        ],
        [
            'name' => 'Botswana',
            'description' => 'BOTSWANA',
            'code' => '267',
            'iso' => 'BW / BWA',
        ],
        [
            'name' => 'Bouvet Island',
            'description' => 'BOUVET ISLAND',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Brazil',
            'description' => 'BRAZIL',
            'code' => '55',
            'iso' => 'BR / BRA',
        ],
        [
            'name' => 'British Indian Ocean Territory',
            'description' => 'BRITISH INDIAN OCEAN TERRITORY (THE)',
            'code' => '246',
            'iso' => 'IO / IOT',
        ],
        [
            'name' => 'British Virgin Islands',
            'description' => 'BRITISH VIRGIN ISLANDS',
            'code' => '1-284',
            'iso' => 'VG / VGB',
        ],
        [
            'name' => 'Brunei',
            'description' => 'BRUNEI DARUSSALAM',
            'code' => '673',
            'iso' => 'BN / BRN',
        ],
        [
            'name' => 'Bulgaria',
            'description' => 'BULGARIA',
            'code' => '359',
            'iso' => 'BG / BGR',
        ],
        [
            'name' => 'Burkina Faso',
            'description' => 'BURKINA FASO',
            'code' => '226',
            'iso' => 'BF / BFA',
        ],
        [
            'name' => 'Burundi',
            'description' => 'BURUNDI',
            'code' => '257',
            'iso' => 'BI / BDI',
        ],
        [
            'name' => 'Cape Verde',
            'description' => 'CABO VERDE',
            'code' => '238',
            'iso' => 'CV / CPV',
        ],
        [
            'name' => 'Cambodia',
            'description' => 'CAMBODIA',
            'code' => '855',
            'iso' => 'KH / KHM',
        ],
        [
            'name' => 'Cameroon',
            'description' => 'CAMEROON',
            'code' => '237',
            'iso' => 'CM / CMR',
        ],
        [
            'name' => 'Canada',
            'description' => 'CANADA',
            'code' => '1',
            'iso' => 'CA / CAN',
        ],
        [
            'name' => 'Cayman Islands',
            'description' => 'CAYMAN ISLANDS (THE)',
            'code' => '1-345',
            'iso' => 'KY / CYM',
        ],
        [
            'name' => 'Central African Republic',
            'description' => 'CENTRAL AFRICAN REPUBLIC (THE)',
            'code' => '236',
            'iso' => 'CF / CAF',
        ],
        [
            'name' => 'Chad',
            'description' => 'CHAD',
            'code' => '235',
            'iso' => 'TD / TCD',
        ],
        [
            'name' => 'Chile',
            'description' => 'CHILE',
            'code' => '56',
            'iso' => 'CL / CHL',
        ],
        [
            'name' => 'China',
            'description' => 'CHINA',
            'code' => '86',
            'iso' => 'CN / CHN',
        ],
        [
            'name' => 'Christmas Island',
            'description' => 'CHRISTMAS ISLAND',
            'code' => '61',
            'iso' => 'CX / CXR',
        ],
        [
            'name' => 'Cocos Islands',
            'description' => 'COCOS (KEELING) ISLANDS (THE)',
            'code' => '61',
            'iso' => 'CC / CCK',
        ],
        [
            'name' => 'Colombia',
            'description' => 'COLOMBIA',
            'code' => '57',
            'iso' => 'CO / COL',
        ],
        [
            'name' => 'Comoros',
            'description' => 'COMOROS (THE)',
            'code' => '269',
            'iso' => 'KM / COM',
        ],
        [
            'name' => 'Democratic Republic of the Congo',
            'description' => 'CONGO (THE DEMOCRATIC REPUBLIC OF THE)',
            'code' => '243',
            'iso' => 'CD / COD',
        ],
        [
            'name' => 'Republic of the Congo',
            'description' => 'CONGO (THE)',
            'code' => '242',
            'iso' => 'CG / COG',
        ],
        [
            'name' => 'Cook Islands',
            'description' => 'COOK ISLANDS (THE)',
            'code' => '682',
            'iso' => 'CK / COK',
        ],
        [
            'name' => 'Costa Rica',
            'description' => 'COSTA RICA',
            'code' => '506',
            'iso' => 'CR / CRI',
        ],
        [
            'name' => 'Croatia',
            'description' => 'CROATIA',
            'code' => '385',
            'iso' => 'HR / HRV',
        ],
        [
            'name' => 'Cuba',
            'description' => 'CUBA',
            'code' => '53',
            'iso' => 'CU / CUB',
        ],
        [
            'name' => 'Curacao',
            'description' => 'CURAÇAO',
            'code' => '599',
            'iso' => 'CW / CUW',
        ],
        [
            'name' => 'Cyprus',
            'description' => 'CYPRUS',
            'code' => '357',
            'iso' => 'CY / CYP',
        ],
        [
            'name' => 'Czech Republic',
            'description' => 'CZECH REPUBLIC (THE)',
            'code' => '420',
            'iso' => 'CZ / CZE',
        ],
        [
            'name' => 'Ivory Coast',
            'description' => 'CÔTE D\'IVOIRE',
            'code' => '225',
            'iso' => 'CI / CIV',
        ],
        [
            'name' => 'Denmark',
            'description' => 'DENMARK',
            'code' => '45',
            'iso' => 'DK / DNK',
        ],
        [
            'name' => 'Djibouti',
            'description' => 'DJIBOUTI',
            'code' => '253',
            'iso' => 'DJ / DJI',
        ],
        [
            'name' => 'Dominica',
            'description' => 'DOMINICA',
            'code' => '1-767',
            'iso' => 'DM / DMA',
        ],
        [
            'name' => 'Dominican Republic',
            'description' => 'DOMINICAN REPUBLIC (THE)',
            'code' => '1-809, 1-829, 1-849',
            'iso' => 'DO / DOM',
        ],
        [
            'name' => 'Ecuador',
            'description' => 'ECUADOR',
            'code' => '593',
            'iso' => 'EC / ECU',
        ],
        [
            'name' => 'Egypt',
            'description' => 'EGYPT',
            'code' => '20',
            'iso' => 'EG / EGY',
        ],
        [
            'name' => 'El Salvador',
            'description' => 'EL SALVADOR',
            'code' => '503',
            'iso' => 'SV / SLV',
        ],
        [
            'name' => 'Equatorial Guinea',
            'description' => 'EQUATORIAL GUINEA',
            'code' => '240',
            'iso' => 'GQ / GNQ',
        ],
        [
            'name' => 'Eritrea',
            'description' => 'ERITREA',
            'code' => '291',
            'iso' => 'ER / ERI',
        ],
        [
            'name' => 'Estonia',
            'description' => 'ESTONIA',
            'code' => '372',
            'iso' => 'EE / EST',
        ],
        [
            'name' => 'Ethiopia',
            'description' => 'ETHIOPIA',
            'code' => '251',
            'iso' => 'ET / ETH',
        ],
        [
            'name' => 'EUROPEAN UNION',
            'description' => 'EUROPEAN UNION',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Falkland Islands',
            'description' => 'FALKLAND ISLANDS (THE) [MALVINAS]',
            'code' => '500',
            'iso' => 'FK / FLK',
        ],
        [
            'name' => 'Faroe Islands',
            'description' => 'FAROE ISLANDS (THE)',
            'code' => '298',
            'iso' => 'FO / FRO',
        ],
        [
            'name' => 'Fiji',
            'description' => 'FIJI',
            'code' => '679',
            'iso' => 'FJ / FJI',
        ],
        [
            'name' => 'FINLAND',
            'description' => 'FINLAND',
            'code' => '358',
            'iso' => 'FI / FIN',
        ],
        [
            'name' => 'France',
            'description' => 'FRANCE',
            'code' => '33',
            'iso' => 'FR / FRA',
        ],
        [
            'name' => 'French Guiana',
            'description' => 'FRENCH GUIANA',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'French Polynesia',
            'description' => 'FRENCH POLYNESIA',
            'code' => '689',
            'iso' => 'PF / PYF',
        ],
        [
            'name' => 'French Southern Territories',
            'description' => 'FRENCH SOUTHERN TERRITORIES (THE)',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Gabon',
            'description' => 'GABON',
            'code' => '241',
            'iso' => 'GA / GAB',
        ],
        [
            'name' => 'Gambia',
            'description' => 'GAMBIA (THE)',
            'code' => '220',
            'iso' => 'GM / GMB',
        ],
        [
            'name' => 'Georgia',
            'description' => 'GEORGIA',
            'code' => '995',
            'iso' => 'GE / GEO',
        ],
        [
            'name' => 'Germany',
            'description' => 'GERMANY',
            'code' => '49',
            'iso' => 'DE / DEU',
        ],
        [
            'name' => 'Ghana',
            'description' => 'GHANA',
            'code' => '233',
            'iso' => 'GH / GHA',
        ],
        [
            'name' => 'Gibraltar',
            'description' => 'GIBRALTAR',
            'code' => '350',
            'iso' => 'GI / GIB',
        ],
        [
            'name' => 'Greece',
            'description' => 'GREECE',
            'code' => '30',
            'iso' => 'GR / GRC',
        ],
        [
            'name' => 'Greenland',
            'description' => 'GREENLAND',
            'code' => '299',
            'iso' => 'GL / GRL',
        ],
        [
            'name' => 'Grenada',
            'description' => 'GRENADA',
            'code' => '1-473',
            'iso' => 'GD / GRD',
        ],
        [
            'name' => 'Guadeloupe',
            'description' => 'GUADELOUPE',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Guam',
            'description' => 'GUAM',
            'code' => '1-671',
            'iso' => 'GU / GUM',
        ],
        [
            'name' => 'Guatemala',
            'description' => 'GUATEMALA',
            'code' => '502',
            'iso' => 'GT / GTM',
        ],
        [
            'name' => 'Guernsey',
            'description' => 'GUERNSEY',
            'code' => '44-1481',
            'iso' => 'GG / GGY',
        ],
        [
            'name' => 'Guinea',
            'description' => 'GUINEA',
            'code' => '224',
            'iso' => 'GN / GIN',
        ],
        [
            'name' => 'Guinea-Bissau',
            'description' => 'GUINEA-BISSAU',
            'code' => '245',
            'iso' => 'GW / GNB',
        ],
        [
            'name' => 'Guyana',
            'description' => 'GUYANA',
            'code' => '592',
            'iso' => 'GY / GUY',
        ],
        [
            'name' => 'Haiti',
            'description' => 'HAITI',
            'code' => '509',
            'iso' => 'HT / HTI',
        ],
        [
            'name' => 'Heard Island and McDonald Islands',
            'description' => 'HEARD ISLAND AND McDONALD ISLANDS',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Holy See',
            'description' => 'HOLY SEE (THE)',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Honduras',
            'description' => 'HONDURAS',
            'code' => '504',
            'iso' => 'HN / HND',
        ],
        [
            'name' => 'Hong Kong',
            'description' => 'HONG KONG',
            'code' => '852',
            'iso' => 'HK / HKG',
        ],
        [
            'name' => 'Hungary',
            'description' => 'HUNGARY',
            'code' => '36',
            'iso' => 'HU / HUN',
        ],
        [
            'name' => 'Iceland',
            'description' => 'ICELAND',
            'code' => '354',
            'iso' => 'IS / ISL',
        ],
        [
            'name' => 'India',
            'description' => 'INDIA',
            'code' => '91',
            'iso' => 'IN / IND',
        ],
        [
            'name' => 'Indonesia',
            'description' => 'INDONESIA',
            'code' => '62',
            'iso' => 'ID / IDN',
        ],
        [
            'name' => 'INTERNATIONAL MONETARY FUND (IMF)',
            'description' => 'INTERNATIONAL MONETARY FUND (IMF)',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Iran',
            'description' => 'IRAN (ISLAMIC REPUBLIC OF)',
            'code' => '98',
            'iso' => 'IR / IRN',
        ],
        [
            'name' => 'Iraq',
            'description' => 'IRAQ',
            'code' => '964',
            'iso' => 'IQ / IRQ',
        ],
        [
            'name' => 'Ireland',
            'description' => 'IRELAND',
            'code' => '353',
            'iso' => 'IE / IRL',
        ],
        [
            'name' => 'Isle of Man',
            'description' => 'ISLE OF MAN',
            'code' => '44-1624',
            'iso' => 'IM / IMN',
        ],
        [
            'name' => 'Israel',
            'description' => 'ISRAEL',
            'code' => '972',
            'iso' => 'IL / ISR',
        ],
        [
            'name' => 'Italy',
            'description' => 'ITALY',
            'code' => '39',
            'iso' => 'IT / ITA',
        ],
        [
            'name' => 'Jamaica',
            'description' => 'JAMAICA',
            'code' => '1-876',
            'iso' => 'JM / JAM',
        ],
        [
            'name' => 'Japan',
            'description' => 'JAPAN',
            'code' => '81',
            'iso' => 'JP / JPN',
        ],
        [
            'name' => 'Jersey',
            'description' => 'JERSEY',
            'code' => '44-1534',
            'iso' => 'JE / JEY',
        ],
        [
            'name' => 'Jordan',
            'description' => 'JORDAN',
            'code' => '962',
            'iso' => 'JO / JOR',
        ],
        [
            'name' => 'Kazakhstan',
            'description' => 'KAZAKHSTAN',
            'code' => '7',
            'iso' => 'KZ / KAZ',
        ],
        [
            'name' => 'Kenya',
            'description' => 'KENYA',
            'code' => '254',
            'iso' => 'KE / KEN',
        ],
        [
            'name' => 'Kiribati',
            'description' => 'KIRIBATI',
            'code' => '686',
            'iso' => 'KI / KIR',
        ],
        [
            'name' => 'The Democratic People’s Republic Of Korea (North Korea)',
            'description' => 'KOREA (THE DEMOCRATIC PEOPLE’S REPUBLIC OF)',
            'code' => '850',
            'iso' => 'KP / PRK',
        ],
        [
            'name' => 'Republic of Korea (South Korea)',
            'description' => 'KOREA (THE REPUBLIC OF)',
            'code' => '82',
            'iso' => 'KR / KOR',
        ],
        [
            'name' => 'Kuwait',
            'description' => 'KUWAIT',
            'code' => '965',
            'iso' => 'KW / KWT',
        ],
        [
            'name' => 'Kyrgyzstan',
            'description' => 'KYRGYZSTAN',
            'code' => '996',
            'iso' => 'KG / KGZ',
        ],
        [
            'name' => 'Laos',
            'description' => 'LAO PEOPLE’S DEMOCRATIC REPUBLIC (THE)',
            'code' => '856',
            'iso' => 'LA / LAO',
        ],
        [
            'name' => 'Latvia',
            'description' => 'LATVIA',
            'code' => '371',
            'iso' => 'LV / LVA',
        ],
        [
            'name' => 'Lebanon',
            'description' => 'LEBANON',
            'code' => '961',
            'iso' => 'LB / LBN',
        ],
        [
            'name' => 'Lesotho',
            'description' => 'LESOTHO',
            'code' => '266',
            'iso' => 'LS / LSO',
        ],
        [
            'name' => 'Liberia',
            'description' => 'LIBERIA',
            'code' => '231',
            'iso' => 'LR / LBR',
        ],
        [
            'name' => 'Libya',
            'description' => 'LIBYA',
            'code' => '218',
            'iso' => 'LY / LBY',
        ],
        [
            'name' => 'Liechtenstein',
            'description' => 'LIECHTENSTEIN',
            'code' => '423',
            'iso' => 'LI / LIE',
        ],
        [
            'name' => 'Lithuania',
            'description' => 'LITHUANIA',
            'code' => '370',
            'iso' => 'LT / LTU',
        ],
        [
            'name' => 'Luxembourg',
            'description' => 'LUXEMBOURG',
            'code' => '352',
            'iso' => 'LU / LUX',
        ],
        [
            'name' => 'Macau',
            'description' => 'MACAO',
            'code' => '853',
            'iso' => 'MO / MAC',
        ],
        [
            'name' => 'Macedonia',
            'description' => 'REPUBLIC OF NORTH MACEDONIA',
            'code' => '389',
            'iso' => 'MK / MKD',
        ],
        [
            'name' => 'Madagascar',
            'description' => 'MADAGASCAR',
            'code' => '261',
            'iso' => 'MG / MDG',
        ],
        [
            'name' => 'Malawi',
            'description' => 'MALAWI',
            'code' => '265',
            'iso' => 'MW / MWI',
        ],
        [
            'name' => 'Malaysia',
            'description' => 'MALAYSIA',
            'code' => '60',
            'iso' => 'MY / MYS',
        ],
        [
            'name' => 'Maldives',
            'description' => 'MALDIVES',
            'code' => '960',
            'iso' => 'MV / MDV',
        ],
        [
            'name' => 'Mali',
            'description' => 'MALI',
            'code' => '223',
            'iso' => 'ML / MLI',
        ],
        [
            'name' => 'Malta',
            'description' => 'MALTA',
            'code' => '356',
            'iso' => 'MT / MLT',
        ],
        [
            'name' => 'Marshall Islands',
            'description' => 'MARSHALL ISLANDS (THE)',
            'code' => '692',
            'iso' => 'MH / MHL',
        ],
        [
            'name' => 'Martinique',
            'description' => 'MARTINIQUE',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Mauritania',
            'description' => 'MAURITANIA',
            'code' => '222',
            'iso' => 'MR / MRT',
        ],
        [
            'name' => 'Mauritius',
            'description' => 'MAURITIUS',
            'code' => '230',
            'iso' => 'MU / MUS',
        ],
        [
            'name' => 'Mayotte',
            'description' => 'MAYOTTE',
            'code' => '262',
            'iso' => 'YT / MYT',
        ],
        [
            'name' => 'Member Countries Of The African Development Bank Group',
            'description' => 'MEMBER COUNTRIES OF THE AFRICAN DEVELOPMENT BANK GROUP',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Mexico',
            'description' => 'MEXICO',
            'code' => '52',
            'iso' => 'MX / MEX',
        ],
        [
            'name' => 'Micronesia',
            'description' => 'MICRONESIA (FEDERATED STATES OF)',
            'code' => '691',
            'iso' => 'FM / FSM',
        ],
        [
            'name' => 'Moldova',
            'description' => 'MOLDOVA (THE REPUBLIC OF)',
            'code' => '373',
            'iso' => 'MD / MDA',
        ],
        [
            'name' => 'Monaco',
            'description' => 'MONACO',
            'code' => '377',
            'iso' => 'MC / MCO',
        ],
        [
            'name' => 'Mongolia',
            'description' => 'MONGOLIA',
            'code' => '976',
            'iso' => 'MN / MNG',
        ],
        [
            'name' => 'Montenegro',
            'description' => 'MONTENEGRO',
            'code' => '382',
            'iso' => 'ME / MNE',
        ],
        [
            'name' => 'Montserrat',
            'description' => 'MONTSERRAT',
            'code' => '1-664',
            'iso' => 'MS / MSR',
        ],
        [
            'name' => 'Morocco',
            'description' => 'MOROCCO',
            'code' => '212',
            'iso' => 'MA / MAR',
        ],
        [
            'name' => 'Mozambique',
            'description' => 'MOZAMBIQUE',
            'code' => '258',
            'iso' => 'MZ / MOZ',
        ],
        [
            'name' => 'Myanmar',
            'description' => 'MYANMAR',
            'code' => '95',
            'iso' => 'MM / MMR',
        ],
        [
            'name' => 'Namibia',
            'description' => 'NAMIBIA',
            'code' => '264',
            'iso' => 'NA / NAM',
        ],
        [
            'name' => 'Nauru',
            'description' => 'NAURU',
            'code' => '674',
            'iso' => 'NR / NRU',
        ],
        [
            'name' => 'Netherlands',
            'description' => 'NETHERLANDS (THE)',
            'code' => '31',
            'iso' => 'NL / NLD',
        ],
        [
            'name' => 'New Caledonia',
            'description' => 'NEW CALEDONIA',
            'code' => '687',
            'iso' => 'NC / NCL',
        ],
        [
            'name' => 'New Zealand',
            'description' => 'NEW ZEALAND',
            'code' => '64',
            'iso' => 'NZ / NZL',
        ],
        [
            'name' => 'Nicaragua',
            'description' => 'NICARAGUA',
            'code' => '505',
            'iso' => 'NI / NIC',
        ],
        [
            'name' => 'Niger',
            'description' => 'NIGER (THE)',
            'code' => '227',
            'iso' => 'NE / NER',
        ],
        [
            'name' => 'Nigeria',
            'description' => 'NIGERIA',
            'code' => '234',
            'iso' => 'NG / NGA',
        ],
        [
            'name' => 'Niue',
            'description' => 'NIUE',
            'code' => '683',
            'iso' => 'NU / NIU',
        ],
        [
            'name' => 'Norfolk Island',
            'description' => 'NORFOLK ISLAND',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Northern Mariana Islands',
            'description' => 'NORTHERN MARIANA ISLANDS (THE)',
            'code' => '1-670',
            'iso' => 'MP / MNP',
        ],
        [
            'name' => 'Norway',
            'description' => 'NORWAY',
            'code' => '47',
            'iso' => 'NO / NOR',
        ],
        [
            'name' => 'Oman',
            'description' => 'OMAN',
            'code' => '968',
            'iso' => 'OM / OMN',
        ],
        [
            'name' => 'Pakistan',
            'description' => 'PAKISTAN',
            'code' => '92',
            'iso' => 'PK / PAK',
        ],
        [
            'name' => 'Palau',
            'description' => 'PALAU',
            'code' => '680',
            'iso' => 'PW / PLW',
        ],
        [
            'name' => 'Palestine',
            'description' => 'PALESTINE, STATE OF',
            'code' => '970',
            'iso' => 'PS / PSE',
        ],
        [
            'name' => 'PANAMA',
            'description' => 'PANAMA',
            'code' => '507',
            'iso' => 'PA / PAN',
        ],
        [
            'name' => 'Papua New Guinea',
            'description' => 'PAPUA NEW GUINEA',
            'code' => '675',
            'iso' => 'PG / PNG',
        ],
        [
            'name' => 'Paraguay',
            'description' => 'PARAGUAY',
            'code' => '595',
            'iso' => 'PY / PRY',
        ],
        [
            'name' => 'Peru',
            'description' => 'PERU',
            'code' => '51',
            'iso' => 'PE / PER',
        ],
        [
            'name' => 'Philippines',
            'description' => 'PHILIPPINES (THE)',
            'code' => '63',
            'iso' => 'PH / PHL',
        ],
        [
            'name' => 'Pitcairn',
            'description' => 'PITCAIRN',
            'code' => '64',
            'iso' => 'PN / PCN',
        ],
        [
            'name' => 'Poland',
            'description' => 'POLAND',
            'code' => '48',
            'iso' => 'PL / POL',
        ],
        [
            'name' => 'Portugal',
            'description' => 'PORTUGAL',
            'code' => '351',
            'iso' => 'PT / PRT',
        ],
        [
            'name' => 'Puerto Rico',
            'description' => 'PUERTO RICO',
            'code' => '1-787, 1-939',
            'iso' => 'PR / PRI',
        ],
        [
            'name' => 'Qatar',
            'description' => 'QATAR',
            'code' => '974',
            'iso' => 'QA / QAT',
        ],
        [
            'name' => 'Romania',
            'description' => 'ROMANIA',
            'code' => '40',
            'iso' => 'RO / ROU',
        ],
        [
            'name' => 'Russia',
            'description' => 'RUSSIAN FEDERATION (THE)',
            'code' => '7',
            'iso' => 'RU / RUS',
        ],
        [
            'name' => 'Rwanda',
            'description' => 'RWANDA',
            'code' => '250',
            'iso' => 'RW / RWA',
        ],
        [
            'name' => 'Reunion',
            'description' => 'RÉUNION',
            'code' => '262',
            'iso' => 'RE / REU',
        ],
        [
            'name' => 'Saint Barthelemy',
            'description' => 'SAINT BARTHÉLEMY',
            'code' => '590',
            'iso' => 'BL / BLM',
        ],
        [
            'name' => 'Saint Helena',
            'description' => 'SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA',
            'code' => '290',
            'iso' => 'SH / SHN',
        ],
        [
            'name' => 'Saint Kitts and Nevis',
            'description' => 'SAINT KITTS AND NEVIS',
            'code' => '1-869',
            'iso' => 'KN / KNA',
        ],
        [
            'name' => 'Saint Lucia',
            'description' => 'SAINT LUCIA',
            'code' => '1-758',
            'iso' => 'LC / LCA',
        ],
        [
            'name' => 'Saint Martin',
            'description' => 'SAINT MARTIN (FRENCH PART)',
            'code' => '590',
            'iso' => 'MF / MAF',
        ],
        [
            'name' => 'Saint Pierre and Miquelon',
            'description' => 'SAINT PIERRE AND MIQUELON',
            'code' => '508',
            'iso' => 'PM / SPM',
        ],
        [
            'name' => 'Saint Vincent and the Grenadines',
            'description' => 'SAINT VINCENT AND THE GRENADINES',
            'code' => '1-784',
            'iso' => 'VC / VCT',
        ],
        [
            'name' => 'Samoa',
            'description' => 'SAMOA',
            'code' => '685',
            'iso' => 'WS / WSM',
        ],
        [
            'name' => 'San Marino',
            'description' => 'SAN MARINO',
            'code' => '378',
            'iso' => 'SM / SMR',
        ],
        [
            'name' => 'Sao Tome and Principe',
            'description' => 'SAO TOME AND PRINCIPE',
            'code' => '239',
            'iso' => 'ST / STP',
        ],
        [
            'name' => 'Saudi Arabia',
            'description' => 'SAUDI ARABIA',
            'code' => '966',
            'iso' => 'SA / SAU',
        ],
        [
            'name' => 'Senegal',
            'description' => 'SENEGAL',
            'code' => '221',
            'iso' => 'SN / SEN',
        ],
        [
            'name' => 'Serbia',
            'description' => 'SERBIA',
            'code' => '381',
            'iso' => 'RS / SRB',
        ],
        [
            'name' => 'Seychelles',
            'description' => 'SEYCHELLES',
            'code' => '248',
            'iso' => 'SC / SYC',
        ],
        [
            'name' => 'Sierra Leone',
            'description' => 'SIERRA LEONE',
            'code' => '232',
            'iso' => 'SL / SLE',
        ],
        [
            'name' => 'Singapore',
            'description' => 'SINGAPORE',
            'code' => '65',
            'iso' => 'SG / SGP',
        ],
        [
            'name' => 'Sint Maarten',
            'description' => 'SINT MAARTEN (DUTCH PART)',
            'code' => '685',
            'iso' => 'WS / WSM',
        ],
        [
            'name' => 'Unitary System Of Regional Payments Compensation "SUCRE"',
            'description' => 'SISTEMA UNITARIO DE COMPENSACION REGIONAL DE PAGOS "SUCRE"',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Slovakia',
            'description' => 'SLOVAKIA',
            'code' => '421',
            'iso' => 'SK / SVK',
        ],
        [
            'name' => 'Slovenia',
            'description' => 'SLOVENIA',
            'code' => '386',
            'iso' => 'SI / SVN',
        ],
        [
            'name' => 'Solomon Islands',
            'description' => 'SOLOMON ISLANDS',
            'code' => '677',
            'iso' => 'SB / SLB',
        ],
        [
            'name' => 'Somalia',
            'description' => 'SOMALIA',
            'code' => '252',
            'iso' => 'SO / SOM',
        ],
        [
            'name' => 'South Africa',
            'description' => 'SOUTH AFRICA',
            'code' => '27',
            'iso' => 'ZA / ZAF',
        ],
        [
            'name' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
            'description' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'South Sudan',
            'description' => 'SOUTH SUDAN',
            'code' => '211',
            'iso' => 'SS / SSD',
        ],
        [
            'name' => 'Spain',
            'description' => 'SPAIN',
            'code' => '34',
            'iso' => 'ES / ESP',
        ],
        [
            'name' => 'Sri Lanka',
            'description' => 'SRI LANKA',
            'code' => '94',
            'iso' => 'LK / LKA',
        ],
        [
            'name' => 'Sudan',
            'description' => 'SUDAN (THE)',
            'code' => '249',
            'iso' => 'SD / SDN',
        ],
        [
            'name' => 'Suriname',
            'description' => 'SURINAME',
            'code' => '597',
            'iso' => 'SR / SUR',
        ],
        [
            'name' => 'Svalbard and Jan Mayen',
            'description' => 'SVALBARD AND JAN MAYEN',
            'code' => '47',
            'iso' => 'SJ / SJM',
        ],
        [
            'name' => 'Swaziland',
            'description' => 'SWAZILAND',
            'code' => '268',
            'iso' => 'SZ / SWZ',
        ],
        [
            'name' => 'Sweden',
            'description' => 'SWEDEN',
            'code' => '46',
            'iso' => 'SE / SWE',
        ],
        [
            'name' => 'Switzerland',
            'description' => 'SWITZERLAND',
            'code' => '41',
            'iso' => 'CH / CHE',
        ],
        [
            'name' => 'Syria',
            'description' => 'SYRIAN ARAB REPUBLIC',
            'code' => '963',
            'iso' => 'SY / SYR',
        ],
        [
            'name' => 'Taiwan',
            'description' => 'TAIWAN (PROVINCE OF CHINA)',
            'code' => '886',
            'iso' => 'TW / TWN',
        ],
        [
            'name' => 'Tajikistan',
            'description' => 'TAJIKISTAN',
            'code' => '992',
            'iso' => 'TJ / TJK',
        ],
        [
            'name' => 'Tanzania',
            'description' => 'TANZANIA, UNITED REPUBLIC OF',
            'code' => '255',
            'iso' => 'TZ / TZA',
        ],
        [
            'name' => 'Thailand',
            'description' => 'THAILAND',
            'code' => '66',
            'iso' => 'TH / THA',
        ],
        [
            'name' => 'Timor-Leste',
            'description' => 'TIMOR-LESTE',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'Togo',
            'description' => 'TOGO',
            'code' => '228',
            'iso' => 'TG / TGO',
        ],
        [
            'name' => 'Tokelau',
            'description' => 'TOKELAU',
            'code' => '690',
            'iso' => 'TK / TKL',
        ],
        [
            'name' => 'Tonga',
            'description' => 'TONGA',
            'code' => '676',
            'iso' => 'TO / TON',
        ],
        [
            'name' => 'Trinidad and Tobago',
            'description' => 'TRINIDAD AND TOBAGO',
            'code' => '1-868',
            'iso' => 'TT / TTO',
        ],
        [
            'name' => 'Tunisia',
            'description' => 'TUNISIA',
            'code' => '216',
            'iso' => 'TN / TUN',
        ],
        [
            'name' => 'Turkey',
            'description' => 'TURKEY',
            'code' => '90',
            'iso' => 'TR / TUR',
        ],
        [
            'name' => 'Turkmenistan',
            'description' => 'TURKMENISTAN',
            'code' => '993',
            'iso' => 'TM / TKM',
        ],
        [
            'name' => 'Turks and Caicos Islands',
            'description' => 'TURKS AND CAICOS ISLANDS (THE)',
            'code' => '1-649',
            'iso' => 'TC / TCA',
        ],
        [
            'name' => 'Tuvalu',
            'description' => 'TUVALU',
            'code' => '688',
            'iso' => 'TV / TUV',
        ],
        [
            'name' => 'Uganda',
            'description' => 'UGANDA',
            'code' => '256',
            'iso' => 'UG / UGA',
        ],
        [
            'name' => 'Ukraine',
            'description' => 'UKRAINE',
            'code' => '380',
            'iso' => 'UA / UKR',
        ],
        [
            'name' => 'United Arab Emirates',
            'description' => 'UNITED ARAB EMIRATES (THE)',
            'code' => '971',
            'iso' => 'AE / ARE',
        ],
        [
            'name' => 'United Kingdom',
            'description' => 'UNITED KINGDOM OF GREAT BRITAIN AND NORTHERN IRELAND (THE)',
            'code' => '44',
            'iso' => 'GB / GBR',
        ],
        [
            'name' => 'United States Minor Outlying Islands',
            'description' => 'UNITED STATES MINOR OUTLYING ISLANDS (THE)',
            'code' => null,
            'iso' => null,
        ],
        [
            'name' => 'United States',
            'description' => 'UNITED STATES OF AMERICA (THE)',
            'code' => '1',
            'iso' => 'US / USA',
        ],
        [
            'name' => 'Uruguay',
            'description' => 'URUGUAY',
            'code' => '598',
            'iso' => 'UY / URY',
        ],
        [
            'name' => 'Uzbekistan',
            'description' => 'UZBEKISTAN',
            'code' => '998',
            'iso' => 'UZ / UZB',
        ],
        [
            'name' => 'Vanuatu',
            'description' => 'VANUATU',
            'code' => '678',
            'iso' => 'VU / VUT',
        ],
        [
            'name' => 'Venezuela',
            'description' => 'VENEZUELA (BOLIVARIAN REPUBLIC OF)',
            'code' => '58',
            'iso' => 'VE / VEN',
        ],
        [
            'name' => 'Vietnam',
            'description' => 'VIET NAM',
            'code' => '84',
            'iso' => 'VN / VNM',
        ],
        [
            'name' => 'British Virgin Islands',
            'description' => 'VIRGIN ISLANDS (BRITISH)',
            'code' => '1-340',
            'iso' => 'VI / VIR',
        ],
        [
            'name' => 'U.S. Virgin Islands',
            'description' => 'VIRGIN ISLANDS (U.S.)',
            'code' => '1-340',
            'iso' => 'VI / VIR',
        ],
        [
            'name' => 'Wallis and Futuna',
            'description' => 'WALLIS AND FUTUNA',
            'code' => '681',
            'iso' => 'WF / WLF',
        ],
        [
            'name' => 'Western Sahara',
            'description' => 'WESTERN SAHARA',
            'code' => '212',
            'iso' => 'EH / ESH',
        ],
        [
            'name' => 'Yemen',
            'description' => 'YEMEN',
            'code' => '967',
            'iso' => 'YE / YEM',
        ],
        [
            'name' => 'Zambia',
            'description' => 'ZAMBIA',
            'code' => '260',
            'iso' => 'ZM / ZMB',
        ],
        [
            'name' => 'Zimbabwe',
            'description' => 'ZIMBABWE',
            'code' => '263',
            'iso' => 'ZW / ZWE',
        ],
        [
            'name' => 'Åland Islands',
            'description' => 'ÅLAND ISLANDS',
            'code' => null,
            'iso' => null,
        ],
    ];

    public static function getCountries(): Collection
    {
        return collect(self::$countries);
    }
}
