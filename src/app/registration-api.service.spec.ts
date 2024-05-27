import { TestBed } from '@angular/core/testing';

import { RegistrationApiService } from './services/registration-api.service';

describe('RegistrationApiService', () => {
  let service: RegistrationApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(RegistrationApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
