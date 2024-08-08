<?php
function HSPLZMN($startDate, $durationMinutes) {
    $vardiyaBaslangic = [
        "08:00", "10:00", "10:15", "12:00", "12:30", "15:00",
        "15:15", "17:30", "22:00", "23:59", "00:30", "03:00",
        "03:15", "06:00", "06:15"
    ];
    $vardiyaBitis = [
        "10:00", "12:00", "12:30", "15:00", "15:15", "00:01",
        "00:30", "03:00", "03:15", "06:00", "06:15", "08:00"
    ];
    $molaBaslangic = [
        "10:00", "12:01", "15:00", "00:01", "03:00", "06:00"
    ];
    $molaBitis = [
        "10:15", "12:30", "15:15", "00:30", "03:15", "06:15"
    ];
    
    $vardiyaBaslangicCumartesi = [
        "00:30", "03:00", "06:15"
    ];
    $vardiyaBitisCumartesi = [
        "03:00", "06:00", "08:00"
    ];
    $molaBaslangicCumartesi = [
        "03:00", "06:00"
    ];
    $molaBitisCumartesi = [
        "03:15", "06:15"
    ];
    
    $bitisZamani = new DateTime($startDate);
    $kalanDakikalar = $durationMinutes;
    $pazartesiBaslangic = (new DateTime($startDate))->modify('next Monday')->setTime(8, 0);
    
    while ($kalanDakikalar > 0) {
        $suAn = clone $bitisZamani;
        $isCumartesi = $suAn->format('N') == 6;
        
        $vardiyaBaslangicTemp = $isCumartesi ? $vardiyaBaslangicCumartesi : $vardiyaBaslangic;
        $vardiyaBitisTemp = $isCumartesi ? $vardiyaBitisCumartesi : $vardiyaBitis;
        $molaBaslangicTemp = $isCumartesi ? $molaBaslangicCumartesi : $molaBaslangic;
        $molaBitisTemp = $isCumartesi ? $molaBitisCumartesi : $molaBitis;
        
        $vardiyaIndex = -1;
        foreach ($vardiyaBaslangicTemp as $i => $start) {
            $startTime = new DateTime($start);
            $endTime = new DateTime($vardiyaBitisTemp[$i]);
            if ($suAn >= $startTime && $suAn < $endTime) {
                $vardiyaIndex = $i;
                break;
            }
        }
        
        if ($vardiyaIndex >= 0) {
            $vardiyaStart = new DateTime($vardiyaBaslangicTemp[$vardiyaIndex]);
            $vardiyaEnd = new DateTime($vardiyaBitisTemp[$vardiyaIndex]);
            $kalanVardiyaDakika = $vardiyaEnd->getTimestamp() - $suAn->getTimestamp();
            $kalanVardiyaDakika /= 60; // convert seconds to minutes
            
            if ($kalanDakikalar <= $kalanVardiyaDakika) {
                $bitisZamani->add(new DateInterval('PT' . $kalanDakikalar . 'M'));
                $kalanDakikalar = 0;
            } else {
                $kalanDakikalar -= $kalanVardiyaDakika;
                if ($vardiyaIndex == count($vardiyaBaslangicTemp) - 1) {
                    $bitisZamani = (clone $suAn)->modify('+1 day')->setTime(8, 0);
                } else {
                    $bitisZamani = new DateTime($vardiyaBaslangicTemp[$vardiyaIndex + 1]);
                }
            }
        } else {
            if ($suAn < new DateTime($vardiyaBaslangicTemp[0])) {
                $bitisZamani = new DateTime($vardiyaBaslangicTemp[0]);
            } else {
                for ($i = 0; $i < count($vardiyaBitisTemp) - 1; $i++) {
                    $endTime = new DateTime($vardiyaBitisTemp[$i]);
                    $nextStart = new DateTime($vardiyaBaslangicTemp[$i + 1]);
                    if ($suAn >= $endTime && $suAn < $nextStart) {
                        $bitisZamani = $nextStart;
                        break;
                    }
                }
                if ($suAn >= new DateTime(end($vardiyaBitisTemp))) {
                    $bitisZamani = (clone $suAn)->modify('+1 day')->setTime(8, 0);
                }
            }
        }
        
        if ($bitisZamani >= new DateTime('08:00') && $bitisZamani->format('N') == 7) {
            $kalanDakikalarCumartesi = (new DateTime('08:00'))->getTimestamp() - $bitisZamani->getTimestamp();
            $kalanDakikalarCumartesi /= 60; // convert seconds to minutes
            $kalanDakikalar += $kalanDakikalarCumartesi;
            $bitisZamani = $pazartesiBaslangic;
        }
        
        $toplamMolaSuresi = 0;
        foreach ($molaBaslangicTemp as $i => $start) {
            $molaStart = new DateTime($start);
            $molaEnd = new DateTime($molaBitisTemp[$i]);
            if ($bitisZamani >= $molaStart && $bitisZamani < $molaEnd) {
                $toplamMolaSuresi += ($molaEnd->getTimestamp() - $molaStart->getTimestamp()) / 60; // convert seconds to minutes
            }
        }
        $bitisZamani->add(new DateInterval('PT' . $toplamMolaSuresi . 'M'));
        
        if ($bitisZamani >= new DateTime('08:00') && $bitisZamani->format('N') == 1) {
            $bitisZamani = $pazartesiBaslangic;
        }
    }
    
    return $bitisZamani->format('Y-m-d H:i:s');
}

// Örnek kullanım
echo HSPLZMN('2024-08-08 09:00:00', 120); // Test
?>
