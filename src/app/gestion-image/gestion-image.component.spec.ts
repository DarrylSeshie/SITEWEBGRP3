import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GestionImageComponent } from './gestion-image.component';

describe('GestionImageComponent', () => {
  let component: GestionImageComponent;
  let fixture: ComponentFixture<GestionImageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [GestionImageComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(GestionImageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
