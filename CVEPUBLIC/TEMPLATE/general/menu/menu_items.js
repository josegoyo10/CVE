var MENU_ITEMS = [
	[' Inicio', '../TEMPLATES/home.htm', null,
		// Submenu
	],
	[' Cotizaci�n/OS', null, null,
		// Submenu
		
		[' Cear Cotizaci�n', 'cot1.htm'],
		[' Monitor Cotizaciones', 'monitor1.htm'],				
	],
	[' Coordinador', null, null,
		// Submenu		
		[' Monitor OT', 'coordinador1.htm'],
		//[' Programaci�n OS', 'monitor2.htm'],
		//[' Ejecuci�n', 'monitor3.htm'],
		//[' Hist�rico OS', null],		
		//[' Liquidaci�n Instalador', 'liq1.htm'],				
	],	
//	[' Despachador', null, null,
		// Submenu
//		[' Lista de Picking', null],
//		[' Lista de Despachos', null],		
//	],		
//	[' Supervisor', null, null,
		// Submenu
//		[' Reporte 1', null],
//		[' Reporte 2', null],
//	],
	[' Utilidades', null, null,
		// Submenu
		[' Datos Personales', ''],
		[' Ayuda', ''],		
	],
	[' Sistema', null, null,
		// Submenu
		[' Adm. Usuarios', ''],
		[' Adm. Perfiles', ''],		
		[' Adm. M�dulos', ''],		
		[' Adm. Cat�logo Proveedor', ''],				
	],	
	[' Salir', 'login.htm', null,
		// Submenu
	],
];
new menu (MENU_ITEMS, MENU_POS);