import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { UserService } from './services/user.service';
import { Observable, of } from 'rxjs';
import { catchError, map, switchMap } from 'rxjs/operators';

export const adminGuard: CanActivateFn = (route, state) => {
  const userService = inject(UserService);
  const router = inject(Router);

  return userService.loadCurrentUser().pipe(
    map(user => {
      if (user && (user.id_role === 1)) {
        return true;
        
      } else {
        router.navigate(['/acceuil']);
        return false;
      }
    }),
    catchError(() => {
      router.navigate(['/acceuil']);
      return of(false);
    })
  );
};
