import { Component, OnInit } from '@angular/core';
import { UserService } from './services/user.service';
import { Observable } from 'rxjs';
import { Router, NavigationEnd } from '@angular/router';
import { filter } from 'rxjs/operators';



@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent implements OnInit {

  isLoggedIn$: Observable<boolean>;

  constructor(private service: UserService, private router: Router) {
    this.isLoggedIn$ = this.service.isLoggedIn;
  }
 

  ngOnInit(): void {
    this.isLoggedIn$.subscribe(isLoggedIn => {
      if (isLoggedIn) {
        this.router.events.pipe(
          filter((event): event is NavigationEnd => event instanceof NavigationEnd)
        ).subscribe((event: NavigationEnd) => {
          if (event.url === '/' || event.url.includes('/connexion')) {
            this.router.navigate(['/acceuil']);
          }
        });
      } else {
        if (!localStorage.getItem('logout')) {
          localStorage.setItem('logout', 'true');
          this.router.navigate(['/']).then(() => {
            window.location.reload(); // Recharge l'onglet après la redirection
          });
        } else {
          localStorage.removeItem('logout');
        }
      }
    });
  }

  
  
 
}
