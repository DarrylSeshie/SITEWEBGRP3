import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GestionInstitutionComponent } from './gestion-institution.component';

describe('GestionInstitutionComponent', () => {
  let component: GestionInstitutionComponent;
  let fixture: ComponentFixture<GestionInstitutionComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [GestionInstitutionComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(GestionInstitutionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
