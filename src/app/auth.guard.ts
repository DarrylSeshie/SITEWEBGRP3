
import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { jwtDecode } from "jwt-decode"; // activer si import reussi

 
export const authGuard: CanActivateFn = (route, state) => {
  const token = inject(CookieService).get("token");
  let decoded;
  if (token) {
    decoded = jwtDecode(token);
  }
  if (decoded && decoded.exp && decoded.exp >= Math.floor(new Date().getTime() / 1000)) {
    return true;
  } else {
    inject(CookieService).delete("token");
    inject(Router).navigate(["/"]);
    return false;
  }
};
