import { ModuleWithProviders }  from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AuthGuard } 			from './utils/guard';

import { painelRoutes }			from './cliente/cliente.routes';
import { usuarioRoutes } 	    from './usuario/usuario.routes';

// Route Configuration
export const routes: Routes = [
	{path: '', redirectTo: '/login', pathMatch: 'full'},
	{path: 'home', component: HomeComponent },
	...painelRoutes		
	//{path: 'home', component: HomeComponent, canActivate: [AuthGuard]}		
];

export const routing: ModuleWithProviders = RouterModule.forRoot(routes);
