public partial class KeresesForm : Form
{
    public KeresesForm()
    {
        InitializeComponent();
    }

    private void KeresesForm_Load(object sender, EventArgs e)
    {
        // Országok feltöltése
        var országok = hidak.Select(h => h.Orszag).Distinct().ToList();
        comboBoxOrszag.Items.AddRange(országok.ToArray());
    }

    private void btnKereses_Click(object sender, EventArgs e)
    {
        string kiválasztottOrszág = comboBoxOrszag.SelectedItem.ToString();
        var találtHidak = hidak.Where(h => h.Orszag == kiválasztottOrszág).Select(h => h.Nev).ToList();
        textBoxEredmeny.Text = string.Join("\n", találtHidak);
    }
}
