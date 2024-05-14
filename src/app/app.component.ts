import { Component } from '@angular/core';
import { CookieService } from 'ngx-cookie-service';
import { UserService } from './services/user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  errorMsg = "";

  constructor(private service: UserService, private cookieService: CookieService, private router: Router) { }

  checkLogin(username: string, password: string) {
    this.service.checkLogin(username, password).subscribe({
      next: (token) => {
        this.cookieService.set("token", token.access_token);
        this.router.navigate(["/"]);
      },
      error: (errorMsg) => { this.errorMsg = errorMsg.error.error; },
      complete: () => { }
    });
  }
 
}
