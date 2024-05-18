import { Component, OnInit } from '@angular/core';
import { UserService } from './services/user.service';
import { Observable } from 'rxjs';



@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent implements OnInit {

  isLoggedIn$ = this.service.isLoggedIn;
  
  constructor(public service: UserService) {  }

  ngOnInit(): void {}

 

  
  
 
}
