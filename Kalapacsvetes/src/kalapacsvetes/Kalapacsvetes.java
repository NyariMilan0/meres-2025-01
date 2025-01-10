package kalapacsvetes;
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Scanner;

public class Kalapacsvetes {


public static void main(String[] args) {
      String filePath = "C:\\Users\\mdrag\\Desktop\\meres\\meres-2025-01\\Kalapacsvetes\\anyagok\\kalapacsvetes.txt";
        ArrayList<Sportolo> sportolok = new ArrayList<>();

        try (BufferedReader reader = new BufferedReader(new FileReader(filePath))) {
            String line = reader.readLine(); // Az első sort átugorjuk, mivel az a fejléc
            while ((line = reader.readLine()) != null) {
                String[] data = line.split(";"); // Pontosvesszővel tagoljuk
                int helyezes = Integer.parseInt(data[0].trim());
                String eredmeny = data[1].trim(); // Az eredmény marad String, vesszővel
                String nev = data[2].trim();
                String orszagKod = data[3].trim();
                String helyszin = data[4].trim();
                String datum = data[5].trim();

                Sportolo sportolo = new Sportolo(helyezes, eredmeny, nev, orszagKod, helyszin, datum);
                sportolok.add(sportolo);
            }
        } catch (IOException e) {
            System.err.println("Hiba a fájl olvasása során: " + e.getMessage());
        }

        System.out.println("4. feladat: " + sportolok.size() + " dobás eredménye található.");

        double osszeg = 0;
        int magyarDobasokSzama = 0;
        for (Sportolo sportolo : sportolok) {
            if ("HUN".equals(sportolo.getOrszagKod())) {
                osszeg += Double.parseDouble(sportolo.getEredmeny().replace(",", ".")); // Átalakítás double értékre
                magyarDobasokSzama++;
            }
        }
        if (magyarDobasokSzama > 0) {
            double atlag = osszeg / magyarDobasokSzama;
            System.out.printf("5. feladat: A magyar sportolók átlagosan %.2f métert dobtak.\n", atlag);
        } else {
            System.out.println("5. feladat: Nem található magyar sportoló a listában.");
        }

        Scanner scanner = new Scanner(System.in);
        System.out.print("6. feladat: Adjon meg egy évszámot:\n");
        String keresettEv = scanner.nextLine();
        boolean talalat = false;
        ArrayList<String> sportoloNevLista = new ArrayList<>();

        for (Sportolo sportolo : sportolok) {
            if (sportolo.getDatum().startsWith(keresettEv)) {
                talalat = true;
                sportoloNevLista.add(sportolo.getNev());
            }
        }

        if (talalat) {
            System.out.println("\t" + sportoloNevLista.size() + " darab dobás került be ebben az évben.");
            for (String nev : sportoloNevLista) {
                System.out.println("\t" + nev);
            }
        } else {
            System.out.println("Egy dobás sem került be ebben az évben.");
        }

        // 7. feladat: Statisztika országkód szerint
        System.out.println("7. feladat: Statisztika");
        HashMap<String, Integer> statisztika = new HashMap<>();
        for (Sportolo sportolo : sportolok) {
            String orszagKod = sportolo.getOrszagKod();
            statisztika.put(orszagKod, statisztika.getOrDefault(orszagKod, 0) + 1);
        }

        for (String orszagKod : statisztika.keySet()) {
            System.out.println("\t"+orszagKod + " - " + statisztika.get(orszagKod) + " dobás");
        }
}
}

