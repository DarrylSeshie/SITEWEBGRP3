import { Image } from '../models/image.model';
import { Lieu } from '../models/lieu.model';
import { TypeProduit } from '../models/typeProduit.model';

export interface Formation {
    id_produit: number;
    titre: string;
    sous_titre: string;
    date_debut: Date;
    date_fin: Date;
    date_fin_inscription: Date;
    descriptif: string;
    objectif: string;
    contenu: string;
    methodologie: string;
    public_cible: string;
    prix: number;
    id_image: number;
    id_lieu: number;
    id_type_produit: number;
  
    // Annotations pour les relations de clés étrangères
    image: Image; // Relation avec l'entité Image
    lieu: Lieu; // Relation avec l'entité Lieu
    typeProduit: TypeProduit; // Relation avec l'entité TypeProduit
  }
  