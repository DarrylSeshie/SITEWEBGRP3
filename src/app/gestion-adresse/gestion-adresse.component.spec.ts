import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GestionAdresseComponent } from './gestion-adresse.component';

describe('GestionAdresseComponent', () => {
  let component: GestionAdresseComponent;
  let fixture: ComponentFixture<GestionAdresseComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [GestionAdresseComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(GestionAdresseComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
