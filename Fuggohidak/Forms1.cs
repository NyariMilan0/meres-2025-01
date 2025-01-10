public partial class Form1 : Form
{
    private List<Fuggohid> hidak = new List<Fuggohid>();

    public Form1()
    {
        InitializeComponent();
    }

    private void Form1_Load(object sender, EventArgs e)
    {
        string filePath = "fuggohidak.csv"; 
        hidak = FuggohidAdatkezelo.FuggohidakBetoltes(filePath);

        foreach (var hid in hidak)
        {
            listBoxHidak.Items.Add(hid.Nev);
        }
    }

    private void listBoxHidak_SelectedIndexChanged(object sender, EventArgs e)
    {
        if (listBoxHidak.SelectedItem != null)
        {
            var kivalasztottHid = hidak.FirstOrDefault(h => h.Nev == listBoxHidak.SelectedItem.ToString());
            textBoxNev.Text = kivalasztottHid.Nev;
            textBoxOrszag.Text = kivalasztottHid.Orszag;
            textBoxEv.Text = kivalasztottHid.Ev.ToString();
            textBoxJellemzo.Text = kivalasztottHid.Jellemzo;
        }
    }

    private void radioButtonElott_CheckedChanged(object sender, EventArgs e)
    {
        if (radioButtonElott.Checked)
        {
            var elotte = hidak.Count(h => h.Ev < 2000);
            MessageBox.Show("A 2000 előtti hidak száma: " + elotte);
        }
    }

    private void radioButton2000Utan_CheckedChanged(object sender, EventArgs e)
    {
        if (radioButton2000Utan.Checked)
        {
            var utana = hidak.Count(h => h.Ev >= 2000);
            MessageBox.Show("A 2000 után épült hidak száma: " + utana);
        }
    }
    private void keresésToolStripMenuItem_Click(object sender, EventArgs e)
{
    KeresesForm keresForm = new KeresesForm();
    keresForm.Show();
    this.Hide();
}

private void kilépésToolStripMenuItem_Click(object sender, EventArgs e)
{
    Application.Exit();
}

}
