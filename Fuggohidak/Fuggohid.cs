using System;
using System.Collections.Generic;
using System.IO;

public static class FuggohidAdatkezelo
{
    public static List<Fuggohid> FuggohidakBetoltes(string filePath)
    {
        List<Fuggohid> hidak = new List<Fuggohid>();

        try
        {
            var sorok = File.ReadAllLines(filePath);
            foreach (var sor in sorok)
            {
                var adatok = sor.Split(';');
                if (adatok.Length == 4)
                {
                    string nev = adatok[0];
                    string orszag = adatok[1];
                    int ev = int.Parse(adatok[2]);
                    string jellemzo = adatok[3];
                    hidak.Add(new Fuggohid(nev, orszag, ev, jellemzo));
                }
            }
        }
        catch (Exception ex)
        {
            Console.WriteLine("Hiba a fájl beolvasásakor: " + ex.Message);
        }

        return hidak;
    }
}
