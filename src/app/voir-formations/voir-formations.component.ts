import { Component } from '@angular/core';

@Component({
  selector: 'app-voir-formations',
  templateUrl: './voir-formations.component.html',
  styleUrl: './voir-formations.component.css'
})
export class VoirFormationsComponent {
  selectedMenu: string = '';

  selectMenu(menu: string) {
    this.selectedMenu = menu;
  }
}
