import { Component } from '@angular/core';
import { UserService } from './services/user.service';
import { Observable } from 'rxjs';



@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {

  isLoggedIn$: Observable<boolean>;
  
  constructor(public service: UserService) {  this.isLoggedIn$ = this.service.isLoggedIn;}


 

  
  
 
}
