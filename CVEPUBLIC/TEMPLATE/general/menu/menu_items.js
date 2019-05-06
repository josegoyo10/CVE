var MENU_ITEMS = [
	[' Inicio', '../TEMPLATES/home.htm', null,
		// Submenu
	],
	[' Cotización/OS', null, null,
		// Submenu
		
		[' Cear Cotización', 'cot1.htm'],
		[' Monitor Cotizaciones', 'monitor1.htm'],				
	],
	[' Coordinador', null, null,
		// Submenu		
		[' Monitor OT', 'coordinador1.htm'],
		//[' Programación OS', 'monitor2.htm'],
		//[' Ejecución', 'monitor3.htm'],
		//[' Histórico OS', null],		
		//[' Liquidación Instalador', 'liq1.htm'],				
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
		[' Adm. Módulos', ''],		
		[' Adm. Catálogo Proveedor', ''],				
	],	
	[' Salir', 'login.htm', null,
		// Submenu
	],
];
new menu (MENU_ITEMS, MENU_POS);