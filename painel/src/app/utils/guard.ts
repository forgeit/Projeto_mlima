import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';

import { Helper } from '../utils/helper';
import { LoginService } from '../login/login.service';

@Injectable()
export class AuthGuard implements CanActivate {

    constructor(private helper: Helper, private ls: LoginService) { }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        if (this.ls.isActive()) {                        
            return true;
        } else {
            this.ls.logout();
            this.helper.navigate('/login', null);
            return false;
        }
    }
}