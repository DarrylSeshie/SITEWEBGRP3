
import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { jwtDecode } from "jwt-decode"; // activer si import reussi
import { UserService } from './services/user.service';




export const authGuard: CanActivateFn = (route, state) => {
  const userService = inject(UserService);
  const router = inject(Router);

  if (userService.isLoggedIn) {
    return true;
  } else {
    userService.logout();
    return false;
  }
};
