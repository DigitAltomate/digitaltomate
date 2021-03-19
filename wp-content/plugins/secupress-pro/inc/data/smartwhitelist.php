<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

$smartwhitelist = array(
	/**
	 * 'folder/file.php' => array(
	 *     'hash1' => true,
	 *     'hash2' => true,
	 *     'hash3' => true,
	 * ),
	 */
	'secupress-pro/core/admin/multisite/centralize-blog-options.php' => array(
		'5c1fad60165889ac46fdcc1fc3ccd6d8' => true,
	),
	'secupress-pro/inc/classes/vendors/pdf/fpdf.php' => array(
		'8b9aa109f8a6d01d8341d52cc72be658' => true,
		'9ba4685cc1e900ebfd6edc5dae1b1f68' => true,
		'fde166fe3ff5d722cbc47b36346e3e1c' => true,
	),
	'secupress-pro/inc/functions/pluggable.php' => array(
		'd98eca5bbfbe64fffc750270f3766e85' => true,
		'15aba0524abb10c349d2d51856d37f6c' => true,
	),
	'wp-rocket/min/index.php' => array(
		'388e1480e109b657b9d50070d234ac96' => true,
	),
	'wp-rocket/min/lib/Minify.php' => array(
		'a863f7923efbf986171fbfdb41af273a' => true,
		'7358e6f8312f29e36cf8cd3149228f32' => true,
	),
	'wp-rocket/min/lib/Minify/ClosureCompiler.php' => array(
		'8182c686fff93ee84307943d3aae617b' => true,
		'0d04a74dae339bd8d2d0465503590819' => true,
	),
	'wp-rocket/min/lib/Minify/YUICompressor.php' => array(
		'b9b88b6e479d7e6d3c61c45c504a70d2' => true,
		'3ada081677d0cf118bba1f4b533b97cf' => true,
	),
	'advanced-uptime-monitor-extension/app/views/admin/statistics_table.php' => array(
		'de7086626281390decfdaef69aaa8ef0' => true,
	),
	'easy-digital-downloads/includes/libraries/fpdf/fpdf.php' => array(
		'8c2f41c78d8704f39074802e0a4f431f' => true,
	),
	'backwpup/inc/class-job.php' => array(
		'42dc8da9ea22c1023943fddd46c34b8a' => true,
	),
	'backwpup/inc/class-page-editjob.php' => array(
		'24f00a7530860c1b3bd3f9c8d16f9ade' => true,
	),
	'backwpup/vendor/SwiftMailer/classes/Swift/Transport/MailInvoker.php' => array(
		'16be884c07b82a9409a5b0cc0e39aab3' => true,
	),
	'backwpup/vendor/SwiftMailer/classes/Swift/Transport/SimpleMailInvoker.php' => array(
		'a0cf061a00c8967fb17fe23b0c632c62' => true,
	),
	'batcache/advanced-cache.php' => array(
		'06fe972cc6499df89f7dcb36e0017a87' => true,
	),
	'buddypress/bp-forums/bbpress/bb-includes/functions.bb-pluggable.php' => array(
		'643957430399d93bada881a40fa22244' => true,
	),
	'buddypress/bp-forums/bbpress/bb-includes/backpress/class.mailer-smtp.php' => array(
		'bfab271770867f737541b88aecb756bb' => true,
		'82825656e7565a8659ff3b16966cdc40' => true,
	),
	'captcha/captcha.php' => array(
		'502781727ec3f25424bbffb2190302e2' => true,
		'000b82377f01b3933b697c27033c4f59' => true,
		'834f7e05875fa83f69598ce3d68782cd' => true,
	),
	'comet-cache/src/includes/traits/Shared/ConditionalUtils.php' => array(
		'5f17c610d81414d3816595354e6f6648' => true,
		'738887ee8598347918f2dcdbc55384c2' => true,
	),
	'comet-cache/src/includes/traits/Shared/SysUtils.php' => array(
		'c90fd5afc8c9abe916729ef81fa442b9' => true,
	),
	'contact-form-7-to-database-extension/CF7DBPlugin.php' => array(
		'5ea73b6e06f770f69ff592fd6d1fad7e' => true,
	),
	'contact-form-7-to-database-extension/ExportToGoogleSS.php' => array(
		'5b82a41b52e474fdef049630c66787f1' => true,
	),
	'contact-form-7-to-database-extension/phpunit/CFDBTransformParserTest.php' => array(
		'f016c7c40d44789241c6c8cb22653115' => true,
		'7729d23d43a87b54527de432c1fabd14' => true,
	),
	'duplicator/duplicator.php' => array(
		'a617c48ebb48ea249eeefcee4fc5fadf' => true,
	),
	'duplicator/classes/class.db.php' => array(
		'8ee7b421313b5049aadcad7aaebf7da9' => true,
	),
	'duplicator/classes/package/class.pack.database.php' => array(
		'a6d6d338741cc8ea0e0e3054cc5f8c26' => true,
	),
	'duplicator/classes/utilities/class.db.php' => array(
		'8dfffcfaffa04b23bff42698b9ec6b05' => true,
	),
	'duplicator/classes/utilities/class.u.php' => array(
		'63d3799eead1295568ca8a468316118b' => true,
	),
	'duplicator/classes/utilities/class.util.php' => array(
		'14378ed93f2ab246a30a6c9c008bf64f' => true,
	),
	'duplicator/classes/package.database.php' => array(
		'c4f7eacff6d398ef9a4059463168a2af' => true,
	),
	'duplicator/classes/utility.php' => array(
		'142ee2525059299fbe3570ed5c749160' => true,
	),
	'duplicator/ctrls/ctrl.package.php' => array(
		'fea4d55c98d336d6ab53fe0e1d07f3c2' => true,
	),
	'duplicator/installer/dtoken.php' => array(
		'c6ae56de1c7b1269fba8ca589f7e9548' => true,
	),
	'duplicator/installer/build/ajax.step1.php' => array(
		'97e6dfea8ae78d10eb7d03084e81b6df' => true,
		'1dba1a11e3a5a5164b453698b25fbbc5' => true,
	),
	'duplicator/installer/build/ajax.step2.php' => array(
		'4e0a51f209bd405231eda1e1e4ccc3ed' => true,
		'b8489151e78b3b671258eb35d1b39b4a' => true,
	),
	'duplicator/installer/build/view.help.php' => array(
		'a7d19a9b980cb4952983ec4310bd7b19' => true,
		'161dd0790d86681d3a1279d91a6dc017' => true,
		'36ac5e2dc7e0966086cf0fe3c7d22701' => true,
	),
	'duplicator/installer/build/view.step0.php' => array(
		'cf87edb2ca9d342ea503bf64ee1f05ac' => true,
	),
	'duplicator/installer/build/view.step1.php' => array(
		'7992af59955c62180888744ba2ffcb69' => true,
		'9b1de705fa80a9a5e6b2df4de409a0f9' => true,
	),
	'duplicator/installer/build/view.step2.php' => array(
		'1e5f5ac39421dbd54096d166f2e6ed97' => true,
		'ad5071ee8b626dc73b17eefecddb16ac' => true,
		'658fb84a0f1f73020a9a475ac4a96bdf' => true,
	),
	'duplicator/installer/build/view.step3.php' => array(
		'ae7cc251ca9818e9108fd5a55cbb258f' => true,
		'b602b4c8ec321552bb2d7395a4dd6511' => true,
		'a746c38cdde43bf37d946afb8d3e05c7' => true,
	),
	'duplicator/installer/build/view.step4.php' => array(
		'3facee5e0e63ddfc731bdd9186900702' => true,
	),
	'duplicator/installer/build/assets/inc.js.php' => array(
		'564ca367221fed1a8d3bd15ad3434c47' => true,
	),
	'duplicator/installer/build/assets/inc.libs.css.php' => array(
		'e33c5ea041126f1a83315d155e0eb79b' => true,
		'b22672ebbb91db37f3a9f1daa5be2303' => true,
		'8c1d69640483efa890a32ea07400226f' => true,
	),
	'duplicator/installer/build/assets/inc.libs.js.php' => array(
		'6bfd8ccb5fb49b17006f093f5107c2f4' => true,
		'efe11e714be20f5ef8042f97f70e8b0a' => true,
		'9e33087f6d2aa527cac05ea2413889d9' => true,
	),
	'duplicator/installer/build/classes/class.conf.srv.php' => array(
		'62ac243049fdcab4058057aad834356d' => true,
	),
	'duplicator/installer/build/classes/class.conf.wp.php' => array(
		'93883cefdbf7e5b8a66bec1851bb2710' => true,
	),
	'duplicator/installer/build/classes/class.engine.php' => array(
		'f27b41611148086c7b35ef4bbb600924' => true,
	),
	'duplicator/installer/build/classes/class.logging.php' => array(
		'c14597dc0f7879d60af9411424d4d8f1' => true,
		'd2c22099ad828b1553a4b3c307899d0e' => true,
	),
	'duplicator/installer/build/classes/class.serializer.php' => array(
		'8d91abe0d2151f76636a3cc0e1598593' => true,
	),
	'duplicator/installer/build/classes/class.server.php' => array(
		'e1964166fe2fb7f786659b9ff8c55f58' => true,
	),
	'duplicator/installer/build/classes/class.utils.php' => array(
		'9df4fd13d6120d54bfd40b1a586c464e' => true,
	),
	'duplicator/installer/build/classes/config/class.conf.srv.php' => array(
		'ebf0110054f74654c740981e4d955cd4' => true,
	),
	'duplicator/installer/build/classes/config/class.conf.wp.php' => array(
		'c69860bfe9b0693feeaad09b896b6265' => true,
	),
	'duplicator/installer/build/classes/util/class.db.php' => array(
		'86d9d35e480b032179db1b1d8417bee8' => true,
	),
	'duplicator/installer/build/classes/util/class.utils.php' => array(
		'7ea15f576f9b3cfdaac987b2c47014f2' => true,
	),
	'duplicator/views/actions.php' => array(
		'9532b5800f211aae78bee541338eaabc' => true,
	),
	'duplicator/views/packages/main/new2.scan.php' => array(
		'95a9d57695f14eef8cebc15061a8b5ed' => true,
		'c4d0ab62ee976e49231dd8ffd7c967ef' => true,
		'63a45732eb7d37cfd25c8672be351355' => true,
	),
	'duplicator/views/settings/general.php' => array(
		'18a350e60433ab2780ed78a7fc5a364c' => true,
		'346b02405a8b8f3cfd2dbe85c5a19750' => true,
	),
	'duplicator/views/settings/packages.php' => array(
		'93a00a9c9a552f7c396c3f3bbfa3e2ab' => true,
	),
	'duplicator/views/tools/diagnostics.php' => array(
		'6ceb6ae33da985cddde118ebb479b930' => true,
	),
	'duplicator/views/tools/diagnostics/inc.settings.php' => array(
		'002fc067a8b5e51bb4bf6490cde452ed' => true,
		'c617b6a4e229b3f2a1bada6672011f45' => true,
	),
	'ewww-image-optimizer/common.php' => array(
		'a0d5a29203744b264e58fbdceed8d03d' => true,
		'64736f77e6ff64748afeb64f37d00c92' => true,
		'7e9103bf7b2410fa113112d98ca91a45' => true,
		'f655c3348e161681d10e59385d4d6331' => true,
	),
	'ewww-image-optimizer/ewww-image-optimizer.php' => array(
		'16e347c69a0f0d3bdc14d3f49c13397b' => true,
		'c32953e697bc2bfce4ba28b5f8fa1629' => true,
	),
	'ewww-image-optimizer/unique.php' => array(
		'5a57afc841e75fe9e79c94338dcf44ae' => true,
	),
	'google-sitemap-generator/sitemap-core.php' => array(
		'bb56eb68260cc72266a0dfcefb4f44ed' => true,
	),
	'jetpack/_inc/lib/admin-pages/class.jetpack-react-page.php' => array(
		'2786d6b2f27cd032b78bee4558e3336e' => true,
		'65143eac6ee9aec043c699c29fa49471' => true,
		'ee923a3ee6641bc27c72ea232247c8b8' => true,
	),
	'jetpack/modules/custom-css/csstidy/data.inc.php' => array(
		'54830fd0e280f135d90e93718f0740b0' => true,
	),
	'jetpack/modules/custom-css/custom-css/preprocessors/lessc.inc.php' => array(
		'fbe26fa02c038616a45972ec08a1e200' => true,
	),
	'mailchimp-for-wp/includes/forms/class-form.php' => array(
		'ada92785b5f86e9f4f9cb1b3ed269dac' => true,
		'34226928bacd65dc424c93837e7080d4' => true,
	),
	'mainwp/class/class-mainwp-system.php' => array(
		'caefdee61b8a2d9361d054b1a0d9025a' => true,
		'3f4f98a0c5786e66993239a8cc9353f1' => true,
		'a174e8b491955bbd1bab49d378af3f0f' => true,
	),
	'mainwp/page/page-mainwp-server-information.php' => array(
		'f94f7da7683e3604e7df3f5e8b41b0c9' => true,
		'87beb527f509d83a5333b194ff40f311' => true,
		'e74fdc0bc3f6690650077e13dc880ace' => true,
	),
	'mainwp/page/page-mainwp-user.php' => array(
		'80d0ab66323d8ea84cba587a70ed4d18' => true,
		'3eea5c4f13c1b4743feb024b409ef9aa' => true,
	),
	'mainwp/table/table-mainwp-manage-sites-list-table.php' => array(
		'b7d2442926f953fc5230651d341301d6' => true,
		'c50f17d4d8347093b926882c3791507f' => true,
		'fc7a1e9cf4e2d03eb253e83cbb8501d7' => true,
	),
	'mainwp-child/class/class-mainwp-child-back-wp-up.php' => array(
		'1e73b642722852c710cb9f3445a0d367' => true,
		'6da317d996c44c99b38fcab4af516a7c' => true,
		'9534715d488079d4acabd92fa8aea769' => true,
	),
	'mainwp-child/class/class-mainwp-child-server-information.php' => array(
		'80ae06d5d6a186e75cb6cc022665464c' => true,
		'0a1c7b534f64f93ef90ede63fa74bbe2' => true,
	),
	'mainwp-child/class/class-mainwp-child.php' => array(
		'6cd1a9de2e45320d99cb9bd2257c4e8e' => true,
		'ae94c09e7d930687ccd4138a3b111b0e' => true,
		'4519aceb8f78e03d723ea368c4dbdc25' => true,
	),
	'mainwp-child/class/class-mainwp-clone.php' => array(
		'adba090ab55413885418c31b8e668233' => true,
		'54b6881aecc55a3cd56d68f23e274b6c' => true,
		'9e26bf931f6ff75fe27be9b7f88fb797' => true,
	),
	'nextgen-gallery/products/photocrati_nextgen/modules/datamapper/package.module.datamapper.php' => array(
		'8c26733738c61465079907463cb4ce3b' => true,
	),
	'nextgen-gallery/products/photocrati_nextgen/modules/nextgen_data/package.module.nextgen_data.php' => array(
		'3ff892893dfd81c611d4bc26a599bf37' => true,
		'ba5b99d5a22b1f74b3e96204e6d8819d' => true,
	),
	'nextgen-gallery/products/photocrati_nextgen/modules/ngglegacy/lib/imagemagick.inc.php' => array(
		'040f15bceb5dcc1a9ff4a63dd9efd3b4' => true,
	),
	'nextgen-gallery/products/photocrati_nextgen/modules/router/package.module.router.php' => array(
		'2f79c96b4b509f5535bbac23b5a19825' => true,
		'407f5963de278e6f86e59e878b1eeb9e' => true,
	),
	'query-monitor/collectors/environment.php' => array(
		'2738deeaceefd6d2e4cea4ba64d9c34c' => true,
	),
	'redux-framework/ReduxCore/framework.php' => array(
		'fd2c6d11fb1cba65155660ec00a6508b' => true,
	),
	'redux-framework/ReduxCore/inc/fields/typography/googlefonts.php' => array(
		'b132804bf012c7d16c27140cadc998aa' => true,
		'319792d1a7a91fb7b4f915f125b4daab' => true,
	),
	'regenerate-thumbnails/regenerate-thumbnails.php' => array(
		'b957329211d2bd46349c04ca60df37bb' => true,
	),
	'si-contact-form/includes/class-fscf-action.php' => array(
		'81da0c540991e1d77a9c7d5f7b377738' => true,
		'624583ff26398bcaba40c21813d9f7e4' => true,
	),
	'si-contact-form/includes/class-fscf-process.php' => array(
		'5f5948222c17cd852109fff29f5a0638' => true,
		'3b1c21ed631dc041bf1260c2fd728992' => true,
	),
	'si-contact-form/includes/class-fscf-util.php' => array(
		'5e508716f6b1ccd60967d0bd61d0725a' => true,
		'3d6af2842c523f6a70b9e1fcf89d7163' => true,
	),
	'tablepress/libraries/excel-reader.class.php' => array(
		'19f80ec31e503cf2ef6d95343690f22f' => true,
	),
	'theme-check/checks/badthings.php' => array(
		'cdf473f018011cd8ebb560a09afac6e5' => true,
		'cb7005e91e1a46e0e87aa61f081f017f' => true,
	),
	'types/library/toolset/toolset-common/classes/validation-cakephp.php' => array(
		'c84d024717feb296de6fa3a5dd204f7e' => true,
	),
	'types/library/toolset/toolset-common/expression-parser/parser.php' => array(
		'422b11e8f72d391c15a5663a76bd53f5' => true,
	),
	'types/library/toolset/toolset-common/lib/adodb-time.inc.php' => array(
		'c3e74572275c11073309f35d5ad09a60' => true,
	),
	'types/library/toolset/toolset-common/lib/cakephp.validation.class.php' => array(
		'46f7caa11a5cb98eeb86964d7edd16c6' => true,
		'12560972d24c4c760a992cd6a5f5f975' => true,
	),
	'types/library/toolset/toolset-common/toolset-forms/lib/CakePHP-Validation.php' => array(
		'3b4713a092bc7f04573b53f80a1b030d' => true,
		'00771adb3118484c560a6270a7b9a072' => true,
	),
	'types/library/toolset/toolset-common/toolset-forms/lib/adodb-time.inc.php' => array(
		'56757b9475c83db8d3a675270c1fa608' => true,
	),
	'types/library/toolset/types/embedded/classes/validation-cakephp.php' => array(
		'eec937e3df8f91ced83db98f5ac35a76' => true,
	),
	'types/library/twig/twig/lib/Twig/Extension/Core.php' => array(
		'b03e33a9ab2403f688acbd3cbe643d1b' => true,
		'b3e83ee4e44e6d4b9eddf55d073b2851' => true,
	),
	'updraftplus/admin.php' => array(
		'7d921dd406075772d8600caf63232cf4' => true,
		'40dc4a468071c20cd1ad70de0da12eb9' => true,
		'6db18819fc010a8b5e0710c6f76f80fe' => true,
	),
	'updraftplus/class-updraftplus.php' => array(
		'1b85c87d5d7de48825c1ea2cbd6bca4c' => true,
		'b03cb84a8354539d72864ecfa1020ed8' => true,
		'47479aa2c3ebd9160d1dc9592412544d' => true,
	),
	'updraftplus/includes/phpseclib/File/X509.php' => array(
		'05e04b8b2d3531c742edbbd7f8546279' => true,
	),
	'updraftplus/includes/phpseclib/Net/SFTP.php' => array(
		'c4f854d4d91c295742a4c598876b5b1f' => true,
	),
	'updraftplus/includes/phpseclib/Net/SSH1.php' => array(
		'3ebb5a6dd1af6b0114523bb91df2ff9b' => true,
	),
	'updraftplus/includes/phpseclib/Net/SSH2.php' => array(
		'6222cb783d690b62df7a4ce40f46aa9c' => true,
	),
	'w3-total-cache/BrowserCache_Environment.php' => array(
		'2dc0942a7341cfcd242f9f53c2a9c526' => true,
		'3b733d90664d4a3fbb60bd0cc7a1ff6f' => true,
		'08d47a391d0ffb0824138927cb9d7df2' => true,
	),
	'w3-total-cache/PgCache_ContentGrabber.php' => array(
		'b5a7eca8eb771bd19910de7fd4cfe22e' => true,
		'd493cb57a96f5d5237c59934fd00af92' => true,
		'4f64ea5c12fd48a40b18304f660230ff' => true,
	),
	'w3-total-cache/lib/CSSTidy/data.inc.php' => array(
		'516492aeb1c37bb2a869863d9f2a21a1' => true,
		'fb1053ac3503e1d2dc94f3fe10c80498' => true,
	),
	'w3-total-cache/lib/Minify/Minify.php' => array(
		'1d80a3f4d9fe9034ce8987c033b48089' => true,
		'33e2820513337347bbda552eaeb745e3' => true,
		'3571fa5eecee61fb039f78762c45d13f' => true,
	),
	'w3-total-cache/lib/Minify/Minify/ClosureCompiler.php' => array(
		'69fcd6ecb7b871134b6dd0a93e7f62b4' => true,
	),
	'w3-total-cache/lib/Minify/Minify/YUICompressor.php' => array(
		'4c2e14268a71d52b74ae1558b929cda5' => true,
	),
	'w3-total-cache/lib/Nusoap/nusoap.php' => array(
		'4d0264267c21f57949246fe718748e76' => true,
		'ad62289c352eee409a21f3276fbefcf3' => true,
	),
	'woocommerce/includes/wc-core-functions.php' => array(
		'a38b08be927daba43a330a708556816e' => true,
		'f404f788a8b5d81146e272333fb3087f' => true,
		'd085b70199c41fef45ca4b6d24a8ae07' => true,
	),
	'woocommerce/includes/shortcodes/class-wc-shortcode-my-account.php' => array(
		'18cee7fc9748cc564d0085411775be14' => true,
		'361ac587d6ec6e54276af9c80ed32141' => true,
	),
	'worker/init.php' => array(
		'dbb5960d6ad8e8ebf3e9ebe093ae3c07' => true,
		'f67c23eb848bccfa369619fb2146d829' => true,
		'd171e0fe8b706faff8c9fa8e67356767' => true,
	),
	'worker/src/Dropbox/Curl.php' => array(
		'020c2a7e8f6bae200f2682b17cf53fb4' => true,
	),
	'worker/src/Dropbox/WebAuth.php' => array(
		'7a9c23219d4879b9a34a742025c5fef4' => true,
	),
	'worker/src/MMB/Backup.php' => array(
		'fe729489cb9d294b46aeed1a0ab132a3' => true,
	),
	'worker/src/MWP/Backup/MysqlDump/DumpFactory.php' => array(
		'5ba67ac6ad75a474a7df7a0d64af6bcf' => true,
	),
	'worker/src/MWP/Backup/MysqlDump/ShellDump.php' => array(
		'27c93d1b7ddef13da4590cbab83a95dd' => true,
	),
	'worker/src/MWP/Http/RedirectResponse.php' => array(
		'4f8595eef0273c516e53484c614f5868' => true,
	),
	'worker/src/PHPSecLib/File/X509.php' => array(
		'ac760408d052d0e088915bb56d894412' => true,
	),
	'worker/src/PHPSecLib/Net/SFTP.php' => array(
		'843feaa62a69c71610c856f7c87dc9bb' => true,
	),
	'worker/src/PHPSecLib/Net/SSH1.php' => array(
		'84ebe67d9cc5e7186eaf5a21e9c6d522' => true,
	),
	'worker/src/PHPSecLib/Net/SSH2.php' => array(
		'507829eb1a0f6a0cb09229ec74005817' => true,
	),
	'worker/src/Symfony/Process/Process.php' => array(
		'247701d0c0d829f5217715e7f7f00513' => true,
	),
	'wptouch/core/class-wptouch-pro.php' => array(
		'fe83983b51608b56b0a12820e8fc0b88' => true,
		'2af7d6d777ecde2780e1c5bdd756467f' => true,
		'6ee73f36fb017889760c47575086ea63' => true,
	),
	'wysija-newsletters/classes/WJ_Upgrade.php' => array(
		'f53e0bf0aef3b15d2d1dae703bce3d97' => true,
	),
	'wysija-newsletters/controllers/back/campaigns.php' => array(
		'6e8bb18f44bbd7552440e1eeba260447' => true,
		'32cd243f79d33c91751ef13adec97e14' => true,
	),
	'wysija-newsletters/helpers/render_engine.php' => array(
		'56eafa90d97afb8d92c0c823b9bee7cb' => true,
	),
	'wysija-newsletters/helpers/server.php' => array(
		'4ac14767c0203c6756e64fded93e680d' => true,
	),
	'wysija-newsletters/helpers/toolbox.php' => array(
		'7fbd3989780c56c5f27a3d50f35d6eca' => true,
	),
	'wysija-newsletters/inc/phpmailer/class.phpmailer.php' => array(
		'090b6cbec90275ed650d28dc2d462554' => true,
	),
	'wysija-newsletters/inc/phpmailer/class.smtp.php' => array(
		'3dacceecedd711dcf55317a2e913051c' => true,
	),
	'wysija-newsletters/views/back/campaigns.php' => array(
		'fad72857446f169d02d82c937a1c9ebf' => true,
		'd6d00ea57809204e78a073a9e963289b' => true,
	),
	'gravityforms-multilingual/vendor/twig/twig/lib/Twig/Extension/Core.php' => array(
		'b03e33a9ab2403f688acbd3cbe643d1b' => true,
	),
	'sitepress-multilingual-cms/vendor/twig/twig/lib/Twig/Extension/Core.php' => array(
		'b03e33a9ab2403f688acbd3cbe643d1b' => true,
		'b3e83ee4e44e6d4b9eddf55d073b2851' => true,
	),
	'woocommerce-multilingual/lib/Twig/Extension/Core.php' => array(
		'2a54f71d0c47fd52594e1a992343d14b' => true,
	),
	'woocommerce-multilingual/vendor/twig/twig/lib/Twig/Extension/Core.php' => array(
		'b3e83ee4e44e6d4b9eddf55d073b2851' => true,
		'259ca6fa55f1285d4d60b95ef51a5587' => true,
	),
	'wpml-media-translation/vendor/twig/twig/lib/Twig/Extension/Core.php' => array(
		'b3e83ee4e44e6d4b9eddf55d073b2851' => true,
	),
	'wpml-string-translation/vendor/twig/twig/lib/Twig/Extension/Core.php' => array(
		'b03e33a9ab2403f688acbd3cbe643d1b' => true,
		'b3e83ee4e44e6d4b9eddf55d073b2851' => true,
	),
	'wpml-translation-management/vendor/twig/twig/lib/Twig/Extension/Core.php' => array(
		'b03e33a9ab2403f688acbd3cbe643d1b' => true,
		'b3e83ee4e44e6d4b9eddf55d073b2851' => true,
	),
);

return $smartwhitelist;
