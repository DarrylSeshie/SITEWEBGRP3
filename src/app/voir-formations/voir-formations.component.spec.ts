import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VoirFormationsComponent } from './voir-formations.component';

describe('VoirFormationsComponent', () => {
  let component: VoirFormationsComponent;
  let fixture: ComponentFixture<VoirFormationsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [VoirFormationsComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(VoirFormationsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
