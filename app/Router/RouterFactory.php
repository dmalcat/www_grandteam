<?php

declare(strict_types=1);

namespace FreshBangApp\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Http\Request;


final class RouterFactory
{
	use Nette\StaticClass;

	/** @var string */
	public const    LOCAL_DEV = 'local_dev',
		DEV_STAGE = 'dev_stage',
		LIVE      = 'live';

	/** @var string[]  */
	public const    REGIONS = [ 'cz', 'sk' ];


	/**
	 * @param Request $request
	 * @param string  $basePath
	 * @return RouteList
	 */
	public static function createRouter(Request $request, $basePath = ''): RouteList
	{
		$router = new RouteList;

		if (self::estimateEnvironment($request) !== self::LIVE) {

			$router->addRoute('', [
				'presenter' 	=> 'Homepage',
				'action' 		=> 'default',
				'region' 		=> self::REGIONS[0]
			], Nette\Routing\Route::ONE_WAY);


			foreach (self::REGIONS as $region) {

				$router->addRoute($basePath . $region . '/', [
					'presenter' 	=> 'Homepage',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/styleguide', [
					'presenter' 	=> 'Styleguide',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/financovani', [
					'presenter' 	=> 'Finance',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/subpage', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'subpage',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/pojisteni-majetku', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'property',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/pojisteni-odpovednosti', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'responsibility',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/pojisteni-odpovednosti', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'responsibility',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/pojisteni-sportovcu', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'athletes',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/podnikatele', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'businessmen',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/motorova-vozidla', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'cars',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/zemedelci', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'farmers',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/pravni-ochrana', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'law',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/zivot-lidi', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'people',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/pojisteni/cestovni-pojisteni', [
					'presenter' 	=> 'Insurance',
					'action' 		=> 'travel',
					'region' 		=> $region
				]);

				// Finance
				$router->addRoute($basePath . $region . '/finance/spotrebitelske-uvery', [
					'presenter' 	=> 'Finance',
					'action' 		=> 'loans',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/finance/podnikatelske-pujcky', [
					'presenter' 	=> 'Finance',
					'action' 		=> 'businessLoans',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/finance/uvery-ze-stavebniho-sporeni', [
					'presenter' 	=> 'Finance',
					'action' 		=> 'savingsLoans',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/finance/konsolidace', [
					'presenter' 	=> 'Finance',
					'action' 		=> 'consolidation',
					'region' 		=> $region
				]);

				// Investments
				$router->addRoute($basePath . $region . '/investice-a-sporeni/', [
					'presenter' 	=> 'Investments',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/investice-a-sporeni/proc-sporit/', [
					'presenter' 	=> 'Investments',
					'action' 		=> 'whySave',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/investice-a-sporeni/rezervotvorna-zivotni-pojisteni/', [
					'presenter' 	=> 'Investments',
					'action' 		=> 'lifeInsurance',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/investice-a-sporeni/penzijni-pripojisteni/', [
					'presenter' 	=> 'Investments',
					'action' 		=> 'pensionInsurance',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/investice-a-sporeni/stavebni-sporeni/', [
					'presenter' 	=> 'Investments',
					'action' 		=> 'buildSavings',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/investice-a-sporeni/investovani-do-opf/', [
					'presenter' 	=> 'Investments',
					'action' 		=> 'opfInvestments',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/investice-a-sporeni/investovani-do-komodit/', [
					'presenter' 	=> 'Investments',
					'action' 		=> 'commodityInvestments',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/investice-a-sporeni/doplnkove-penzijni-spoření/', [
					'presenter' 	=> 'Investments',
					'action' 		=> 'extraPensionInsurance',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/investice-a-sporeni/fondy-kvalifikovanych-investoru/', [
					'presenter' 	=> 'Investments',
					'action' 		=> 'qualifiedInvestors',
					'region' 		=> $region
				]);

				// Other Services
				$router->addRoute($basePath . $region . '/ostatni-sluzby/', [
					'presenter' 	=> 'OtherServices',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/ostatni-sluzby/prumyslova-pojisteni', [
					'presenter' 	=> 'OtherServices',
					'action' 		=> 'industrialInsurance',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/ostatni-sluzby/pojisteni-dopravcu', [
					'presenter' 	=> 'OtherServices',
					'action' 		=> 'carrierInsurance',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/ostatni-sluzby/dotace-eu', [
					'presenter' 	=> 'OtherServices',
					'action' 		=> 'euSubsidy',
					'region' 		=> $region
				]);

				// Partners
				$router->addRoute($basePath . $region . '/partneri/kafa-team-sport', [
					'presenter' 	=> 'Partners',
					'action' 		=> 'kafa',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/partneri/ok-holding', [
					'presenter' 	=> 'Partners',
					'action' 		=> 'okHolding',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/partneri/ok-real-estate', [
					'presenter' 	=> 'Partners',
					'action' 		=> 'okRealEstate',
					'region' 		=> $region
				]);

				// News
				$router->addRoute($basePath . $region . '/novinky', [
					'presenter' 	=> 'News',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/novinky/gesto-v-cene-cheeseburgeru', [
					'presenter' 	=> 'News',
					'action' 		=> 'gesto',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/novinky/jak-financovat-rekonstrukci', [
					'presenter' 	=> 'News',
					'action' 		=> 'reconstruction',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/novinky/prumerna-ulozka-do-penzijnich-fondu-je-750-korun-a-to-je-malo', [
					'presenter' 	=> 'News',
					'action' 		=> 'pensionFunds',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/o-nas', [
					'presenter' 	=> 'About',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/partneri', [
					'presenter' 	=> 'Partners',
					'action' 		=> 'default',
					'region' 		=> $region
				]);

				$router->addRoute($basePath . $region . '/kontakt', [
					'presenter' 	=> 'Contact',
					'action' 		=> 'default',
					'region' 		=> $region
				]);
			}

		} else {

			$router->addRoute('//www.domain-name.cz', [
				'presenter' => 'Homepage',
				'action'    => 'default',
				'region'    => 'cz'
			], Nette\Routing\Route::ONE_WAY);

			$router->addRoute('//www.domain-name.sk', [
				'presenter' => 'Homepage',
				'action'    => 'default',
				'region'    => 'sk'
			], Nette\Routing\Route::ONE_WAY);

			$router->addRoute('//www.domain-name.cz/', [
				'presenter' 	=> 'Homepage',
				'action' 		=> 'default',
				'region' 		=> 'cz'
			]);

			$router->addRoute('//www.domain-name.sk/', [
				'presenter' 	=> 'Homepage',
				'action' 		=> 'default',
				'region' 		=> 'sk'
			]);
		}

        $urlToRedirect = array(
            'o_nas-1/o_nas' => 'About:default',
            'o_nas-1/kariera' => 'About:default',
            'o_nas-1/kontakty' => 'Contact:default',
            'financovani/spotrebitelske_uvery_na_bydleni' => 'Finance:loans',
            'financovani/spotrebitelske_uvery' => 'Finance:default',
            'financovani/konsolidace' => 'Finance:consolidation',
            'financovani/podnikatelske_pujcky' => 'Finance:businessLoans',
            'financovani/uvery_ze_stavebniho_sporeni' => 'Finance:savingsLoans',
            'investovani_a_sporeni/proc_sporit' => 'Investments:whySave',
            'investovani_a_sporeni/rezervotvorna_zivotni_pojisteni' => 'Investments:lifeInsurance',
            'investovani_a_sporeni/penzijni_pripojisteni' => 'Investments:pensionInsurance',
            'investovani_a_sporeni/stavebni_sporeni' => 'Investments:buildSavings',
            'investovani_a_sporeni/investovani_do_opf' => 'Investments:opfInvestments',
            'investovani_a_sporeni/invesovani_do_komodit' => 'Investments:commodityInvestments',
            'pojisteni/majetek' => 'Insurance:property',
            'pojisteni/odpovednost' => 'Insurance:responsibility',
            'pojisteni/motorova_vozidla' => 'Insurance:cars',
            'pojisteni/cestovni_pojisteni' => 'Insurance:travel',
            'pojisteni/zivot_lidi' => 'Insurance:people',
            'pojisteni/podnikatele' => 'Insurance:businessmen',
            'pojisteni/profesionalni_sportovci' => 'Insurance:athletes',
            'pojisteni/zemedelci_agro' => 'Insurance:farmers',
            'pojisteni/pravni_ochrana' => 'Insurance:law',
            'ostatni_sluzby/prumyslova_pojisteni' => 'OtherServices:industrialInsurance',
            'ostatni_sluzby/pojisteni_dopravcu' => 'Homepage:default',
            'ostatni_sluzby/pojisteni_profesionalnich_sportovcu' => 'OtherServices:carrierInsurance',
            'ostatni_sluzby/pojisteni_zemedelcu_agro' => 'Insurance:farmers',
            'ostatni_sluzby/dotace_eu' => 'OtherServices:euSubsidy',
            'nasi_partneri/aukce_vozu' => 'Partners:default',
            'nasi_partneri/realitni_sluzby' => 'Partners:default',
            'nasi_partneri/pece_o_aktivni_sportovce' => 'Partners:default',
            'aktuality' => 'News:default',
            'o_nas-1' => 'About:default',
            'financovani' => 'Finance:default',
            'investovani_a_sporeni' => 'Investments:default',
            'pojisteni' => 'Insurance:default',
            'ostatni_sluzby' => 'OtherServices:default',
            'nasi_partneri' => 'Partners:default',
            'hypotecni_restart_se_odklada_na_neurcito_vymodleny_pad_cen_bytu_neprichazi' => 'Homepage:default',
            'cesi-uprednostnuji-nezivotni-pojisteni-pred-zivotnim' => 'Homepage:default',
            'jak_na_hypoteku_jakou_nyni_volit_fixaci_a_kdy_se_vyplati_prestup_jinam' => 'Homepage:default',
            'registrace' => 'Homepage:default',
            'registrace/ztracene_heslo' => 'Homepage:default',
            'objednavka' => 'Homepage:default',
            'duchody_v_roce_2023_cekaji_zmeny_valorizace_vychovne_i_prispevek_pro_prarodice' => 'Homepage:default',
            'jak_financovat_rekonstrukci_vlastnimi_zdroji_ci_uverem' => 'Homepage:default',
            'gesto_v_cene_cheeseburgeru_hypoteky_opet_zlevnily_lepsi_urok_si_lide_musi_vyhadat' => 'Homepage:default',
            'prumerna-ulozka-do-penzijnich-fondu-je-750-korun-a-to-je-malo' => 'Homepage:default',
            'obliba-sporeni-ve-tretim-ctvrtleti-prudce-klesla' => 'Homepage:default',
            'inflace_v_srpnu_2022_po_dlouhe_dobe_zpomalila' => 'Homepage:default',
            'pohled_zlate_koruny_osobni_rozpocet_aneb_jak_si_dat_penize_do_poradku' => 'Homepage:default',
            'evropske-akcie-spadly-na-mesicni-minimum-obavaji-se-raznych-kroku-centralnich-bank' => 'Homepage:default',
            'cena-elektriny-roste-na-burze-eex-poprve-prekrocila-700-eur-za-megawatthodinu' => 'Homepage:default',
            'inflace_stoupla_na_17_5_procenta_ceny_nadale_rostou_nejvice_potraviny_a_energie' => 'Homepage:default',
            'co_by_si_meli_v_pojisteni_ohlidat_chatari_a_chalupari' => 'Homepage:default',
            'rada_cnb_zrejme_necha_urokovou_sazbu_na_sedmi_procentech' => 'Homepage:default',
            'kam_vlozit_penize' => 'Homepage:default',
            'zivotni_pojistky_a_inflace' => 'Homepage:default',
            'ceny-energii-pujdou-opet-nahoru-1' => 'Homepage:default',
            'nejprudsi-narust-od-roku-2020-evropske-akcie-smazaly-veskere-ztraty-ktere-utrpely-valkou' => 'Homepage:default',
            'cesi_vykupuji_zlate_cihly_a_mince_mohou_za_to_valka_na_ukrajine_a_obavy_z_inflace' => 'Homepage:default',
            'co_jsou_zakladni_zivotni_financni_produkty_je_to_pojisteni_a_penzijni_a_podilove_fondy' => 'Homepage:default',
            'hodnota-kryptomen-klesa-bitcoin-se-dostal-na-nejnizsi-cenu-od-lonskeho-srpna' => 'Homepage:default',
            'tip_na_novorocni_predsevzeti_ktere_se_vyplati_zacnete_konecne_investovat' => 'Homepage:default',
            'hypoteky_v_zaveru_roky_by_urokove_sazby_mohly_atakovat_hranici_4_procent' => 'Homepage:default',
            'podnikate_jaky_budete_mit_duchod' => 'Homepage:default',
            'misto_soudu_o_zivotni_pojisteni_zmena_smlouvy' => 'Homepage:default',
            'jak_spravovat_sve_osobni_finance' => 'Homepage:default',
            'kdo-setri-ma-jistotu' => 'Homepage:default',
            'pojistky-pro-seniory' => 'Homepage:default',
            'zari_zdravotni_pojisteni' => 'Homepage:default',
            'nakup-drahych-kovu' => 'Homepage:default',
            'predcasne-ukonceni-stavebka' => 'Homepage:default',
            'dotace-na-najemne' => 'Homepage:default',
            'prace_v_nouzovem_stavu' => 'Homepage:default',
            'vedlejsak-a-dane-v-10-bodech' => 'Homepage:default',
            'zamestnavatel-je-v-insolvenci' => 'Homepage:default',
            'rekordni-rok-2020' => 'Homepage:default',
            'odpovednost-zamestnance' => 'Homepage:default',
            'odpocet-uroku-z-hypoteky' => 'Homepage:default',
            'zlato-jako-pojistka-pred-krizi' => 'Homepage:default',
            'vyhodnost-statni-pujcky' => 'Homepage:default',
            'opet-drazsi-skolni-rok' => 'Homepage:default',
            'prispevek-na-penzijko' => 'Homepage:default',
            'ulevy_pro_male_podnikatele' => 'Homepage:default',
            'zkracena-pracovni-doba' => 'Homepage:default',
            'dluhy-na-zdravotnim-pojisteni' => 'Homepage:default',
            'proc-si-pojistit-storno-cesty' => 'Homepage:default',
            'trvaly_pobyt_v_najmu' => 'Homepage:default',
            'vice-penez-za-nemoc' => 'Homepage:default',
            'o_multibanking_neni_zajem' => 'Homepage:default',
            'dovolena-chorvatsko-italie' => 'Homepage:default',
            'stat-miliardu-na-alimenty' => 'Homepage:default',
            'predmanzelska_smlouva' => 'Homepage:default',
            'mimoradna-okamzita-pomoc' => 'Homepage:default',
            'reklamace_energii' => 'Homepage:default',
            'budou-skrty-nebo-nebudou' => 'Homepage:default',
            'pozadejte-banku-o-chargeback' => 'Homepage:default',
            'investicim-se-dari' => 'Homepage:default',
            'hromadne_propousteni' => 'Homepage:default',
            'jak_zdanit_prijmy_z_investic' => 'Homepage:default',
            'davky-dlouhodobe-osetrovne' => 'Homepage:default',
            'komodity-nejen-pro-bohate' => 'Homepage:default',
            'hypoteky_v_lednu_zdrazily' => 'Homepage:default',
            'pesimisticke_odhady_hypotek' => 'Homepage:default',
            'cnb-ma-duvod-k-opatrnosti' => 'Homepage:default',
            'bitcoin-na-minimu' => 'Homepage:default',
            'danova-uspora-u-financnich-produktu' => 'Homepage:default',
            'danove-priznani-2019' => 'Homepage:default',
            'aktualizace-pojistek' => 'Homepage:default',
            'najemnik-co-neplati' => 'Homepage:default',
            'cestovni_pojisteni_na_hory' => 'Homepage:default',
            'neplacene_volno_v_roce_2019' => 'Homepage:default',
            'led-zadejte-odskodneni' => 'Homepage:default',
            'realitni-trh-ochlazuje' => 'Homepage:default',
            'nepreplacejte-az-40-000-kc' => 'Homepage:default',
            'zivnostnici_vydajove_pausaly' => 'Homepage:default',
            'strop_ceny_zemedelske_pudy' => 'Homepage:default',
            'danove_novinky_pro_rok_2019' => 'Homepage:default',
            'zadluzeni_prazane' => 'Homepage:default',
            'hypoteky' => 'Homepage:default',
            'investice_do_vody' => 'Homepage:default',
            'prispevky_na_sport' => 'Homepage:default',
        );

        foreach ($urlToRedirect as $old => $new) {
            $router->addRoute($old, $new, Nette\Routing\Route::ONE_WAY);
        }


		return $router;
	}


	/**
	 * @param Request $request
	 * @return string
	 */
	private static function estimateEnvironment(Request $request): string
	{
		static $hostPatterns = [
			'localhost'                    => self::LOCAL_DEV,
			'domain-name\.freshdev80\.cz'  => self::DEV_STAGE,
			'www\.domain-name\.cz'         => self::LIVE,
			'www\.domain-name\.sk'         => self::LIVE
		];

		$host = $request->getUrl()->getHost();

		foreach ($hostPatterns as $pattern => $env) {
			if (Nette\Utils\Strings::match($host, "~^$pattern$~")) {
				return $env;
			}
		}

		return self::LOCAL_DEV;
	}
}
