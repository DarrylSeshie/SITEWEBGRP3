import { Component, ElementRef, ViewChild } from '@angular/core';



declare const bootstrap: any;
@Component({
  selector: 'app-acceuil',
  templateUrl: './acceuil.component.html',
  styleUrl: './acceuil.component.css'
})
export class AcceuilComponent {

  @ViewChild('liveToastBtn') toastTrigger!: ElementRef;
  @ViewChild('liveToast') toastLiveExample!: ElementRef;
  constructor(private elementRef: ElementRef) {}

  ngAfterViewInit(): void {
    if (this.toastTrigger && this.toastLiveExample) {
      const toastBootstrap = new bootstrap.Toast(this.toastLiveExample.nativeElement);

      this.toastTrigger.nativeElement.addEventListener('click', () => {
        toastBootstrap.show();
      });
    }
  }
}
