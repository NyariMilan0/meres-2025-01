package kalapacsvetes;
public class Sportolo {
    private int helyezes;
    private String eredmeny;
    private String nev;
    private String orszagKod;
    private String helyszin;
    private String datum;

    // Konstruktor
    public Sportolo(int helyezes, String eredmeny, String nev, String orszagKod, String helyszin, String datum) {
        this.helyezes = helyezes;
        this.eredmeny = eredmeny;
        this.nev = nev;
        this.orszagKod = orszagKod;
        this.helyszin = helyszin;
        this.datum = datum;
    }

    public int getHelyezes() {
        return helyezes;
    }

    public String getEredmeny() {
        return eredmeny;
    }

    public String getNev() {
        return nev;
    }

    public String getOrszagKod() {
        return orszagKod;
    }

    public String getHelyszin() {
        return helyszin;
    }

    public String getDatum() {
        return datum;
    }

    @Override
    public String toString() {
        return helyezes + ";" + eredmeny + ";" + nev + ";" + orszagKod + ";" + helyszin + ";" + datum;
    }
}
