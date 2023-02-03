
# MyDATA 

### Module by evansg  
### version >= v1.7  
### For Dolibarr >= 12.x

## Εγκατάσταση

Μεταβείτε στο Dolibarr: Ρυθμίσεις -> Ενότητες / Εφαρμογές

![install](https://user-images.githubusercontent.com/93765174/211640223-58ff7584-0905-4552-b377-6317cd4f8ac9.png)


## Τι υποστηρίζει

ℹ️ Το module υποστηρίζει την αποστολή παραστατικών αυτόματα μόνο για τα παρακάτω προς το παρόν

1. Παραστατικά σε Ελληνικό ΑΦΜ
2. Παραστατικά σε Ευρωπαϊκό ΑΦΜ
3. Παραστατικά σε τρίτες χώρες (Δεν χρειάζεται να υπάρχει ΑΦΜ)
4. Αποδείξεις λιανικής σε όλες τις χώρες

| Είδη παραστατικών ΑΑΔΕ  | invoice Type | classification Category |
| ----------------------  | ------------- | ------------- |
| Τιμολόγιο Πώλησης  | 1.1 | category1_1 |
| Τιμολόγιο Πώλησης/Ενδοκοινοτικές Παραδόσεις  | 1.2 | category1_1 |
| Τιμολόγιο Πώλησης/Παραδόσεις Τρίτων Χωρών | 1.3| category1_1 |
| Τιμολόγιο Παροχής Υπηρεσιών | 2.1 | category1_3 |
| Τιμολόγιο Παροχής/Ενδοκοινοτική Παροχή Υπηρεσιών  | 2.2 | category1_3 |
| Τιμολόγιο Παροχής/Παροχή Υπηρεσιών Τρίτων Χωρών  | 2.3 | category1_3 |
| Πιστωτικό Τιμολόγιο / Μη Συσχετιζόμενο | 5.2 | category1_1 |
| Πιστωτικό Τιμολόγιο / Μη Συσχετιζόμενο /Ενδοκοινοτικές Παραδόσεις   | 5.2 | category1_1 |
| Πιστωτικό Τιμολόγιο / Μη Συσχετιζόμενο /Παραδόσεις Τρίτων Χωρών   | 5.2 | category1_1 |
| ΑΛΠ (Απόδειξη Παροχής Υπηρεσιών) | 11.1 | category1_3 |
| ΑΠΥ (Απόδειξη Λιανικής Πώλησης)  | 11.2 | category1_2 |
| Πιστωτικό Στοιχείο Λιανικής  | 11.4 | category1_2 |

• Αναγνωρίζει αυτόματα τη χώρα

Αν πρόκειται για Ελλάδα. Αναγνωρίζει το ποσοστό % του ΦΠΑ 

![vat](https://user-images.githubusercontent.com/93765174/211630040-c2dcdde0-14cc-4e09-81c9-b8d8cfe9f703.png)

Αν πρόκειται για χώρα της Ευρωπαϊκής ένωσης (ενδοκοινοτικές αποστολές / θέτει εξαίρεση
ΦΠΑ).

Αν πρόκειται για άλλο νόμισμα πέραν του EURO στέλνει στην ΑΑΔΕ τον κωδικό και ποσό του
ξένου νομίσματος καθώς και την ισοτιμία ( exchange rate) που είναι περασμένο στο
τιμολόγιο του dolibarr. Π.χ USD, 1.20.

### ΠΡΟΣΟΧΗ: 
Είναι σημαντικό να έχετε περασμένα σωστά τα στοιχεία του πελάτη σας αλλιώς η ΑΑΔΕ
δεν θα δεχτεί το τιμολόγιο και θα εμφανίσει μήνυμα λάθους υποδεικνύοντας τι δεν βρήκε.
Είναι σημαντικό να έχετε περασμένα τα παρακάτω πεδία στον πελάτη του dolibarr.

• Όνομα (Τιμολόγια μόνο)

• Διεύθυνση (Τιμολόγια μόνο)

• Ταχ. Κώδικας(Τιμολόγια μόνο)

• Πόλη (Τιμολόγια μόνο)

• Χώρα * (Μπορεί να επιλέξει αυτόματα την Ελλάδα αν δεν είναι δηλωμένη χώρα)

• ΑΦΜ * Σε πελάτες τιμολογίου Ελλάδας & Ευρώπης), Για λιανική δεν χρειάζεται.

## Παραμετροποίηση / Configuration Module

Μεταβείτε στο Dolibarr: Ρυθμίσεις -> Ενότητες / Εφαρμογές -> MYDATA
Θα πρέπει να βλέπετε το παρακάτω module. 

![enable](https://user-images.githubusercontent.com/93765174/211631585-7359e733-bc0d-4dd8-ac0a-05deef05a569.png)

Ενεργοποιήστε το module και πατήστε το γρανάζι για τις ρυθμίσεις.

Σε αυτή τη σελίδα μπορείτε να παραμετροποιήσετε το module ανάλογα με τις ανάγκες σας.

![conf](https://user-images.githubusercontent.com/93765174/211641644-7912e1a9-ffbb-4bdb-b5ed-44fd6384b093.png)



> :warning: Δεν λειτουργεί, δεν υπαρχει διαθεσιμο link στην ΑΑΔΕ. Τελευταια ενημερωση 10/1/2022
> 
> Προτείνεται να μεταβείτε πρώτα στο δοκιμαστικό περιβάλλον της ΑΑΔΕ https://www.aade.gr/epiheiriseis/mydata-ilektronika-biblia-aade/mydata/tehnikes-prodiagrafes-ekdoseis-mydata και να φτιάξετε έναν χρήστη/κλειδί (με το ΑΦΜ της εταιρίας σας) ώστε να
κάνετε τις δοκιμές σας και να σιγουρέψετε ότι όλα πάνε καλά. Τουλάχιστον εκεί δεν υπάρχει κίνδυνος να
στείλετε κάτι που δεν πρέπει.
Ενεργοποιήστε το παρακάτω κουμπί και όλα τα δεδομένα πάνε στην «κόλαση» οπότε κάντε τις
δοκιμές σας άφοβα.

Εισάγετε το εταιρικό σας ΑΦΜ (μόνο νούμερα) καθώς και τα στοιχεία που έχετε από την ΑΑΔΕ. Αν
δοκιμάζετε στο development περιβάλλον εισάγετε αυτά του δοκιμαστικού.

![test](https://user-images.githubusercontent.com/93765174/211638295-da274bed-0847-409d-bb8c-c1e5e2c1c72d.png)

Στο παρακάτω link βρίσκεται το documentation της ΑΑΔΕ για το τι κωδικούς χρειάζεστε.

https://www.aade.gr/sites/default/files/2022-09/myDATA%20API%20Documentation%20v1.0.6_official_erp.pdf

Οι παρακάτω είναι οι πιο κοινοί, αν δεν είστε σίγουροι συμβουλευτείτε το λογιστή σας.

![m](https://user-images.githubusercontent.com/93765174/211126461-3309f174-9594-49fe-a0fa-f08029e8274e.png)

Αναζήτηση με ημερομηνία

![date](https://user-images.githubusercontent.com/93765174/211643977-c2ce6f7d-b03b-4105-a29b-0e89291eb252.png)

##### OFF
Εδώ έχετε την επιλογή να εμφανίζονται μόνο τα παραστατικά που είναι ανοιχτά (απλήρωτα) και
δεν έχουν αποσταλεί ακόμα στην AADE αφαιρέστε τα // από την παρακάτω γραμμή.
##### ON
Εδώ έχετε την επιλογή να εμφανίζονται όλα τα παραστατικά από την ημερομηνία που θα δηλώσετε
μέχρι και τώρα και δεν έχουν αποσταλεί ακόμα στην AADE.
* Στο πεδίο της ημερομηνίας τοποθετήστε την ημερομηνία που θέλετε. (ΧΡΟΝΟΣ-ΜΗΝΑΣ-ΗΜΕΡΑ
π.χ 2021-09-01).

Ανάλογα με τι όνομα δίνεται στα παραστατικά σας ακολουθήστε την παρακάτω οδηγία.

![name](https://user-images.githubusercontent.com/93765174/211644736-e9c068e2-9d22-4cf1-9b3b-5c1803e54ba3.png)


Υποστήριξη Παραστατικών με πολλαπλό ΦΠΑ: Εάν ή επιλογή αυτή είναι ενεργοποιημένη τότε θα
αποστέλλονται στην ΑΑΔΕ, αναλυτικά όλές οι γραμμές του παραστατικού με το κάθε ΦΠΑ. Στην
αντίθετη περίπτωση αποστέλεται το παραστατικό χωρίς ανάλυση των γραμμών.
Παραστατικά χωρίς χώρα: Εάν ή επιλογή αυτή είναι ενεργοποιημένη τότε για τα παραστατικά που
δεν έχει καταχωρηθεί χώρα , θα επιλέγεται η Ελλάδα

![vat country](https://user-images.githubusercontent.com/93765174/211644803-8932b514-ff6c-4a46-828f-e3298c679d15.png)


Κάθε παραστατικό πρέπει να κατηγοριοποιηθεί πριν αποσταλεί στην AADE. Δείτε την παρακάτω εικόνα.

![use](https://user-images.githubusercontent.com/93765174/211645144-9882bc7f-9165-4033-888d-96d593564c37.png)

> :warning: Εάν δεν επιλέξετε κάτι από τη λίστα, θεωρεί πως η default επιλογή είναι το «Τιμολόγιο Πώλησης»

Πατήστε στο MyDATA module επάνω στη λίστα και θα μεταβείτε στον πίνακα που δείχνει ποια
παραστατικά, με βάση τις προτιμήσεις που κάνατε πριν, είναι διαθέσιμα.

![table](https://user-images.githubusercontent.com/93765174/211645437-4c1d7151-3885-4e02-bd2a-27d2c18d93ab.png)

Το κάθε παραστατικό πλέον έχει διαθέσιμα δύο (2) πεδία.


• MyData Sent: Δηλώνει αν στάλθηκε στην AADE (γίνεται πράσινο μόνο αν έχει
επιβεβαιωμένα αποσταλεί στην AADE και έχει πάρει κωδικό MARK (Μοναδικό Αριθμό
Καταχώρησης της AADE)
• MyDATA Reply: Ημερομηνία που στάλθηκε και τι κωδικό πήρε. Μπορεί να εμφανίσει
MARK ή και το μήνυμα λάθους εάν για κάποιο λόγο έχει σφάλματα το παραστατικό.

Πατώντας το κουμπί "Αποστολή στο MyDATA θα ξεκινήσει η σειριακή διαδικασία αποστολής στην AADE όλων
των παραστατικών που είναι στη λίστα.

Μόλις η διαδικασία αποστολής ολοκληρωθεί, θα πρέπει να δείτε κάτι αντίστοιχο με το παρακάτω

![sent](https://user-images.githubusercontent.com/93765174/211647032-9054aae9-c24f-4c4b-ad6c-343c4db82dee.png)

Όλα τα παραστατικά έχουν σταλεί και το MyDATA Sent έχει πάρει το πράσινο εικονίδιο ότι ήταν
επιτυχής η αποστολή. Επίσης έχουν πάρει ημερομηνία και «MARK» κωδικό στο MyDATA Reply.

Στον παραπάνω πίνακα μπορούμε να παρατηρήσουμε πως έχει αποστείλει παραστατικά:

• Για Ελλάδα, με 24% ΦΠΑ (Αναγράφει και το % ΦΠΑ)
• Για Ευρωπαϊκή Ένωση (με απαλλαγή ΦΠΑ , ενδοκοινοτικά)
• Σε τρίτες χώρες με συνάλλαγμα.Κάνοντας click στο κουμπί «Refresh Page» εμφανίζονται ποια έχουν μείνει στη λίστα – δεν
στάλθηκαν.

Σκόπιμα για το παράδειγμα μας διακρίνεται ένα παραστατικό που έχει μηδενική τιμή. Η ΑΑΔΕ δεν
το δέχτηκε οπότε εμφανίζεται και το μήνυμα λάθους. Το MyDATA Sent δεν έχει γίνει πράσινο.

![error](https://user-images.githubusercontent.com/93765174/211647542-a92148b7-5b14-485f-b3f4-55a52a62f485.png)

Αν πάμε να δούμε ένα παραστατικό από την λίστα μας, μπορούμε να παρατηρήσουμε τον MARK
κωδικό καθώς και αν στάλθηκε σωστά

![inv](https://user-images.githubusercontent.com/93765174/211647732-ee6ce78b-255f-46e4-b826-0f637fe35a9c.png)

Στην περίπτωση που θέλουμε να το εμφανίσουμε πάλι στην λίστα μας σαν «μη απεσταλμένο»
μπορούμε χειροκίνητα να πατήσουμε το edit στο MyDATA Sent και να αφαιρέσουμε την επιλογή
ότι στάλθηκε.

### Tip
Υπάρχει και η δυνατότητα να γίνεται η αποστολή αυτόματα ανά τακτά χρονικά διαστήματα. Π.χ να βρίσκει
κάθε 5 λεπτά ποια παραστατικά είναι διαθέσιμα για αποστολή και να τα στέλνει στην AADE.

Μεταβείτε στο Ρυθμίσεις -> Ενότητες / Εφαρμογές -> Προγραμματισμένες εργασίες και ενεργοποιήστε την ενότητα.
Έπειτα μεταβείτε στο Αρχική -> Εργαλεία διαχειριστή -> Προγραμματισμένες εργασίες.
Εκεί πατηστε το + icon και συμπληρώστε όπως παρακάτω.
Σε αυτό το παράδειγμα στέλνει ανά ώρα. 

![send](https://user-images.githubusercontent.com/93765174/211648707-ec48a58c-2dba-4892-8141-6c706cafd3dd.png)


> :warning: Σύμφωνα με τις οδηγίες της ΑΑΔΕ το αργότερο που μπορείτε να κάνετε αποστολή είναι η επόμενη ημέρα.
> Απο 1/1/2024 η αποστολή θα πρέπει να γίνεται σε πραγματικό χρόνο.
